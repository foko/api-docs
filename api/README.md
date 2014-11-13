(DEPRECATED - STAY TUNED FOR NEW RELEASE)
**Foko API**

Take your Foko photos and put them on your Intranet, Word Press, Drop Box, wherever!

Here's how:

> In order to proceed, you must email a request for an API Key from "api@foko.co". This api key will be used in the header (foko-api-key) when making api requests.

All of your photos can be queried at the following URL:

    https://cloud.foko.co/api/v1/photos

You can make GET request with the API KEY in the header to retrieve you photos.  Here is an example using "curl":

    curl -X GET -H "foko-api-key: APIKEY" https://cloud.foko.co/api/v1/photos

This will return you a JSON array of 20 photos in this format:

    [{
        "description": "The first photo description",
        "largeImage": "https://cloud.foko.co/api/v1/photo/somefile-l.jpg/ABC123/DEF456",
        "mediumImage": "https://cloud.foko.co/api/v1/photo/somefile-m.jpg/ABC123/DEF456",
        "smallImage": "https://cloud.foko.co/api/v1/photo/somefile-s.jpg/ABC123/DEF456",
        "objectId": "ABCDEFGHJJ",
	"linkToFoko":"https://app.foko.co/launch?photo=ABCDEFGHJJ",
        "createdAt": "2014-09-02T17:14:34.847Z",
        "updatedAt": "2014-09-02T17:14:34.847Z",
        "likeCount": 20,
        "commentCount": 13,
        "isPrivate": false,
        "largeImageLength": 51186,
        "mediumImageLength": 7836,
        "smallImageLength": 1786,
        "owner": {
            "firstName": "Colin",
            "lastName": "McDonald",
            "email": "cmcdonald@foko.co",
            "title": "Marketer",
            "objectId": "NXu4MsGmZo",
	    "linkToFoko":"https://app.foko.co/launch?follower=NXu4MsGmZo",
            "createdAt": "2014-08-11T10:29:13.749Z",
            "updatedAt": "2014-09-02T17:29:36.828Z",
            "image": {
                "largeImage": "https://cloud.foko.co/api/v1/photo/somefile-l.jpg/ABC123/DEF456",
                "mediumImage": "https://cloud.foko.co/api/v1/photo/somefile-m.jpg/ABC123/DEF456",
                "smallImage": "https://cloud.foko.co/api/v1/photo/somefile-s.jpg/ABC123/DEF456",
            }
        }
    }]

Once you recieve your list of files, you can parse the JSON results and make separate requests to download the binary photo files as specified in the "largeImage", "mediumImage" and "smallImage" properties.

Photos can be queried by date.  You can use the createdAt or updatedAt properties to filter photos.  When you make a GET request, you can send a "where" querystring parameter that contains your filter information.  Please note that the date format is important and must be specified in JSON like this:

    {"__type":"Date","iso":"2014-08-06T18:12:46.546Z"}

Here are some examples of filter in curl:

    curl -X GET -H "foko-api-key: APIKEY" -G --data-urlencode 'where={"updatedAt":{"$lte":{"__type":"Date","iso":"2014-08-06T18:12:46.546Z"}}}' https://cloud.foko.co/api/v1/photos

    curl -X GET -H "foko-api-key: APIKEY" -G --data-urlencode 'where={"createdAt":{"$gt":{"__type":"Date","iso":"2014-08-06T18:12:46.546Z"}}}' https://cloud.foko.co/api/v1/photos    

Note in the previous examples that the filter operations where "$lte" and "$gt".  This supported operations are as follows:

-Less than: $lt
-Less than or equal to: $lte
-Greater than: $gt
-Greater than or equal to: $gte
-And: $and = to be used in conjunction with two of the above

An example combining two filters:

    "createdAt": {
        "$and": {
            "$gt": {
                "__type": "Date",
                "iso": "2014-08-06T18:12:46.546Z"
            },
            "$lte": {
                "__type": "Date",
                "iso": "2014-08-07T18:12:46.546Z"
            }
        }
    }

Photos can be paginated.  Use the skip and limit to paginate through your photos.

    curl -X GET -H "foko-api-key: 456" -G --data-urlencode 'limit=20' --data-urlencode 'skip=1' https://cloud.foko.co/api/v1/photos

    curl -X GET -H "foko-api-key: 456" -G --data-urlencode 'limit=20' --data-urlencode 'skip=2' https://cloud.foko.co/api/v1/photos
