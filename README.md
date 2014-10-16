**Foko Customer API**


> In order to proceed, an api key is required. This api key will need to be added to the header (foko-api-key) when making api requests

All of your photos can be queried at the following URL:

    https://cloud.foko.co/api/v1/photos

You can make GET request with the API KEY in the header to retrieve you photos.  Here is an example using "curl":

    curl -X GET -H "foko-api-key: APIKEY" https://cloud.foko.co/api/v1/photos

This will return you a JSON array of 20 photos in this format:

    [{
        "description": "The photo description",
        "largeImage": "https://cloud.foko.co/api/v1/photo/somefile-l.jpg/ABC123/DEF456",
        "mediumImage": "https://cloud.foko.co/api/v1/photo/somefile-m.jpg/ABC123/DEF456",
        "smallImage": "https://cloud.foko.co/api/v1/photo/somefile-s.jpg/ABC123/DEF456",
        "objectId": "ABCDEFGHJJ",
        "createdAt": "2014-09-02T17:14:34.847Z",
        "updatedAt": "2014-09-02T17:14:34.847Z"
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