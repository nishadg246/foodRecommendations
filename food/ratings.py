import json
import copy
import sys

DEFAULT_WEIGHTED_SCORE = 3



with open("prevs.txt") as prev:
	try:
		restaurantList = json.load(prev)
	except:
		with open("aijsdfiasjdfasjdkfaf.txt", 'w') as ais:
			ais.write('wihe')
		sys.exit()
for restaurant in restaurantList:
	restaurant[1] = int(restaurant[1])
	if(restaurant[2] == "American (New)"):
		restaurant[2] = "newamerican"
	elif(restaurant[2] == "Indian"):
		restaurant[2] = "indpak"
	elif(restaurant[2] == "Fast Food"):
		restaurant[2] = "hotdogs"
	elif(restaurant[2] in ['Chinese', 'Mexican', 'Vegetarian', 'Pizza']):
		restaurant[2] = restaurant[2].lower()
	else:
		restaurant[2] = 'newamerican'
print restaurantList
#assuming dictionary is of the form [list,Of,Places,Chronologically], nested list with each sublist being [restaurant_name, category, liked] 
#IN REVERSE ORDER (most recent first)
#each category starts out with a weight of 100

likes = {'mexican':None, 'chinese':None, 'indpak':None, 'newamerican':None, 'vegetarian':None, 'pizza':None, 'hotdogs':None} #default weighting of likes
for category in likes:
	likes[category] = DEFAULT_WEIGHTED_SCORE
for restaurant in restaurantList:
	likes[restaurant[2]] += 2*int(restaurant[1])
	if likes[restaurant[2]] < 0:
		likes[restaurant[2]] = 0
print likes
weightingSum = sum([likes[restaurant] for restaurant in likes])
categoryCounts = {}
for category in likes:
	categoryCounts[category] = round(21 * float(likes[category])/weightingSum)
previousRestaurants = [restaurant[0] for restaurant in restaurantList]
with open('output.txt', 'w') as output:
	json.dump({"categoryCounts":categoryCounts, "previousRestaurants": previousRestaurants}, output)
