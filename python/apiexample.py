import json
import os
import urllib
import urllib2
from datetime import datetime
import csv

apiKey = "APIKEY"
# url = "https://raph.parseapp.com/api/v1/photos/"
url = "https://raph.parseapp.com/api/v1/photos?%s"
host = "raph.parseapp.com"
path = "/api/v1/photos"
pathQuery = "/api/v1/photos?%s"
headers = {"foko-api-key": apiKey}
images = []
fileNameBackup = "backup.csv"
rowsToSkip = 1

def writeToCsv(titlerow):
    shouldDelete = False
    if shouldDelete:
        try:
            os.remove(fileNameBackup)
        except OSError:
            return
    if os.path.exists(fileNameBackup):
        return
    try:
        file = open(fileNameBackup, 'wt')
        writer = csv.writer(file)
    except Exception as e:
        print e.reason()

    if titlerow:
        try:
            writer.writerow(titlerow)
        finally:
            file.close()


def pullData(startDate, endDate):
    # Date is the following format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' (ISO 8601)
    # Example: 2014-10-01T23:49:36.353Z
    # today = datetime.now().isoformat()[:-3] + 'Z'

    # Create CSV with the given headers
    writeToCsv(("ObjectId", "IsoDate", "ImageUrl"))

    skip = 0
    limit = 150
    count = limit
    total = 0

    while count is limit:

        # first run - no date range given
        if not startDate and not endDate:
            params = urllib.urlencode({'limit': limit, 'skip': skip})

        # for querying before a certain endDate
        if not startDate and endDate:
            params = urllib.urlencode({"where": json.dumps({
                "createdAt": {
                    "$lte": {
                        "__type": "Date",
                        "iso": endDate
                    }
                }
            }), 'limit': limit, 'skip': skip})

        # for querying after a certain startDate - say the last time a job was run
        if startDate and not endDate:
            params = urllib.urlencode({"where": json.dumps({
                "createdAt": {
                    "$gte": {
                        "__type": "Date",
                        "iso": startDate
                    }
                }
            }), 'limit': limit, 'skip': skip})

        # for querying a date range
        if startDate and endDate:
            params = urllib.urlencode({"where": json.dumps({
                "createdAt": {
                    "$and": {
                        "$gte": {
                            "__type": "Date",
                            "iso": startDate
                        },
                        "$lt": {
                            "__type": "Date",
                            "iso": endDate
                        }
                    }
                }
            }), 'limit': limit, 'skip': skip})

        #make a json request
        request = urllib2.Request(url % params, None, headers)
        try:
            response = urllib2.urlopen(request)
            data = json.load(response)
        except urllib2.URLError, e:
            print e.reason
            return
        except NameError:
            print "Json response failed"
            return
        except Exception as e:
            print e.reason
            return

        #append the results to a csv file
        with open(fileNameBackup, 'a') as f:
            try:
                writer = csv.writer(f)
                for item in data:
                    images.append(item["largeImage"])  #temp
                    writer.writerow((item["objectId"], item["createdAt"], item["largeImage"]))
            except Exception as e:
                print e.reason

        count = len(data)
        total += count
        skip += limit

    print "The total number of images downloaded is " + str(total)

    # open the csv file and download the images
    count = 0
    with open(fileNameBackup, "rb") as f:
        reader = csv.reader(f)
        #skip rows that are not needed
        for i in range(rowsToSkip): next(reader)
        for row in reader:
            req = urllib2.Request(row[2], None, headers)
            response = urllib2.urlopen(req)
            #fileToSave = 'foko_%s.jpg' % ''.join(c for c in row[1] if c.isalnum())
            count += 1
            fileToSave = 'foko_%d.jpg' % count
            output = open(fileToSave, 'wb')
            output.write(response.read())
            output.close()
            print row

pullData("2014-10-08T17:10:44.055Z", "")




