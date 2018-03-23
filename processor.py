import requests
import csv
import re
import html5lib
from bs4 import BeautifulSoup


endresult = []

#endresult.append(["Team","Date","Opponent","Closing Line","Total","Score","Win/Lose","Over/Under"])


#who to check

baseurl = 'http://www.vegasinsider.com'

with open('schools3.csv', 'rb') as f:
	reader = csv.reader(f)
	schools = list(reader)

for school in schools:

	name = school[0]
	newurl = school[1]

	url = baseurl + newurl

	print "Working on: " + name

	
	#and away we go! gather info for this school

	response = requests.get(url)

	soup = BeautifulSoup(response.content, "html5lib")


	tables = soup.findAll('table')

	#print "number of tables is "
	#print len(tables)

	table = tables[12]

	rows = table.findChildren('tr')

	rows.pop(0)

	for row in rows:

		cells = row.findChildren('td')

		#Date
		date_p = cells[0].contents
		date = date_p[0].strip()

		#Opponent
		opponent_url = cells[1].findAll('a')

		if opponent_url:  #check if there was a URL at all
			opponent_array = opponent_url[0].contents
			opponent = opponent_array[0].string
			opponent = opponent.replace(";","")
		else:            #if not, then just get the text
			opponent = cells[1].get_text()
			opponent = re.sub('\n','',opponent)
			opponent = re.sub('\r','',opponent)
			opponent = re.sub('\t','',opponent)
			opponent = re.sub('\xa0',' ',opponent)
			opponent = opponent.strip()
			opponent = opponent.replace(u'\xe2',"").replace(u'\u20ac',"").replace(u'\u201c',"-")

		#closing line
		line = cells[2].string
		line = re.sub('\n','',line)
		line = re.sub('\r','',line)
		line = re.sub('\t','',line)
		line = re.sub('\xa0',' ',line)
		line = line.strip()
		if line == "":
			line = "N/A"
		elif line.isspace():
			line = "N/A"

		#total
		total = cells[3].string
		total = re.sub('\n','',total)
		total = re.sub('\r','',total)
		total = re.sub('\t','',total)
		total = re.sub('\xa0',' ',total)
		total = total.strip()
		if total == "":
			total = "N/A"
		elif total.isspace():
			total = "N/A"

		#result
		result = cells[4].string
		result = re.sub('\n','',result)
		result = re.sub('\r','',result)
		result = re.sub('\t','',result)
		result = re.sub('\xa0',' ',result)
		result = result.strip()

		if result == "":
			result = "N/A"
		elif total.isspace():
			result = "N/A"

		#winlose
		ats = cells[5].string
		ats = re.sub('\n','',ats)
		ats = re.sub('\r','',ats)
		ats = re.sub('\t','',ats)
		ats = re.sub('\xa0',' ',ats)

		#print ats

		if ats == "":
			winlose = "N/A"
			overunder = "N/A"		

		elif ats.isspace():
			winlose = "N/A"
			overunder = "N/A"	

		else:
			split = ats.split('/')
			
			#have to account for a few cases where only Win/Lose
			if len(split) < 2:
				winlose = split[0]
				overunder = "Data Needed"
			else:
				winlose = split[0].rstrip()

				overunder = split[1].lstrip()
				overunder = overunder.rstrip()

		#print results

		array = [name,date,opponent,line,total,result,winlose,overunder]

		#print array

		endresult.append(array)

#print endresult

with open("result.csv", "wb") as f:
	writer = csv.writer(f)
	writer.writerows(endresult)



	






