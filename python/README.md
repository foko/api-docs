**Foko Customer API - Python**


> In order to proceed, an api key is required. This api key will need to be added to the header when making api requests

The following libraries will be used in this example, ensure that they are imported:

    import json
    import urllib
    import urllib2

To perform a query,  create a parameter object. This can be done using urllib. A simple example is shown below where photos can be paginated with skip and limit:

    params = urllib.urlencode({'limit': 200, 'skip': 100})

The limit has a range of 1-1000, and denotes the maximum number of results that can be obtained at once. Skip is used to skip a set of results. In the above example the first 100 are skipped and a maximum of 200 results are retrieved. This is useful for looping through results should one have a large number of photos to retrieve.

The header must contain an api key. Create a header object to be used when performing requests:

    headers = {"foko-api-key": “INSERT KEY HERE”}

To perform a simple GET request to retrieve all photos without any constraints the following can be done:

    #make a json request
    url = "https://cloud.foko.co/api/v1/photos?%s"
    request = urllib2.Request(url % params, None, headers)
            try:
                response = urllib2.urlopen(request)
                data = json.load(response)
            except urllib2.URLError, e:
                print e.reason
                return
            except NameError:
                print "Json could not be parsed, response failed."
                return



An example of the json that would be returned, with some of the important items that could be saved in a csv file for keeping a record:

    [
        {
            "description": "The photo description",
            "largeImage": "https://cloud.foko.co/api/v1/photo/tfss-ee7146c0-bc6e-479c-844c-f81d5109e00c-file/0KHxQgHd1d/nmFRcVvJRn",
            "largeImageLength": 113585,
            "mediumImage": "https://cloud.foko.co/api/v1/photo/tfss-5ea1e1b8-a320-44d3-991f-8ec51f6ed4fd-file/0KHxQgHd1d/nmFRcVvJRn",
            "mediumImageLength": 47498,
            "objectId": "ABCDEF1234",
            "createdAt": "2014-09-26T01:26:20.169Z",
            "updatedAt": "2014-09-26T01:26:20.169Z",
        }
    ]

The attribute “createdAt” is a filtering criteria used to retrieve photos by date. The format of this date is ISO 8601 in millisecond precision. To perform a query to retrieve all photos past a certain date (but not including that specific date), the parameter object would be:

    # Date is the following format: yyyy-MM-dd'T'HH:mm:ss.SSS'Z' (ISO 8601)
    startDate = “2014-10-01T23:49:36.353Z”
    params = urllib.urlencode({"where": json.dumps({
                    "createdAt": {
                        "$gt": {
                            "__type": "Date",
                            "iso": startDate
                        }
                    }
                }), 'limit': limit, 'skip': skip});

To retrieve all photos before a certain date $gt would be replaced by $lt (less than). The supported constraint parameters are:

    $gt = greater than
    $lt = less than
    $gte = greater than or equal to
    $lte = greater than or equal to
    $and = to be used in conjunction with two of the above

To retrieve photos that were added after October 1st, up to and including October 8th, the parameter object would be:

    startDate = 2014-10-01T00:00:00.000Z
    endDate = 2014-10-08T00:00:00.000Z
    # for querying a date range
    params = urllib.urlencode({"where": json.dumps({
                    "createdAt": {
                        "$and": {
                            "$gt": {
                                "__type": "Date",
                                "iso": startDate
                            },
                            "$lte": {
                                "__type": "Date",
                                "iso": endDate
                            }
                        }
                    }
                }), 'limit': limit, 'skip': skip});

To download a series of photos, one could iterate through the json object and use the ‘largeImage’ attribute as the download URL:

    #data is retrieved from the previous response object
    for item in data:
        req = urllib2.Request(item["largeImage"], None, headers)
        response = urllib2.urlopen(req)
        output = open(“foko, 'wb')
        output.write(response.read())
        output.close()
