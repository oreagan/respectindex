import requests
import csv
import re
import html5lib
from bs4 import BeautifulSoup

baseurl = 'https://www.covers.com/sports/NCAAB/matchups?selectedDate='

month = '2016-12'
filename = month + ".csv"

endresult = []

#array = ['team_home','team_away','score_home','score_away','odds','date','gametype','conf_home','conf_away']

#with open(filename, "wb") as f:
#	writer = csv.writer(f)
#	writer.writerow(array)

for i in range (1,32):
	date = month + '-' + str(i)

	url = baseurl + date

	response = requests.get(url)

	soup = BeautifulSoup(response.content,"html5lib")

	mydivs = soup.find_all("div", class_="cmg_matchup_game_box")

	game_count = len(mydivs)

	i = 0;

	def hasNumbers(inputString):
		return any(char.isdigit() for char in inputString)

	for game in mydivs:

		f = str(game)

		sep = '>'
		rest = f.split(sep,1)[0]
		s = rest.split('" ')

		confa = s[1].split('"')
		conf_away = confa[1]

		confh = s[11].split('"')
		conf_home = confh[1]

		scorea = s[2].split('"')
		score_away = scorea[1]

		scoreh = s[12].split('"')
		score_home = scoreh[1]

		datex = s[7].split('"')
		datey = datex[1].split(' ')
		date = datey[0]

		oddsx = s[8].split('"')
		odds = oddsx[1]

		typex = s[3].split('"')
		gametype = typex[1]


		names = soup.find_all("div", class_="cmg_matchup_header_team_names")

		namey = str(names[i]).split('">')[1]
		namez = re.sub('\n','',namey)
		namez = re.sub('</div>','',namez)
		
		if ' vs ' in namez:
			names = namez.strip().split(' vs ')
	
		else:
			names = namez.strip().split(' at ')

		team_away = names[0]
		team_home = names[1]


		#print team_away + "vs" + team_home

		if hasNumbers(team_away):
			teama = team_away.split(') ')
			team_away = teama[1]
		if hasNumbers(team_home):
			teamh = team_home.split(') ')
			team_home = teamh[1]

		array = [team_home,team_away,score_home,score_away,odds,date,gametype,conf_home,conf_away]

		if hasNumbers(odds):
			#with open(filename, "a") as f:
			#	writer = csv.writer(f)
			#	writer.writerow(array)
			endresult.append(array)

		i=i+1

with open(filename, "wb") as f:
	writer = csv.writer(f)
	writer.writerows(endresult)




