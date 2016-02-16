# Foko public API (V0)

## Retrieve Company's Photo Feed
### Url Endpoint
```
GET https://api.foko.io/public/api/v0/posts
```
### Query Paramters
* **access_token** - please request a access token by contacting Foko support 'api@foko.co'
* **hashtag** - query posts with specific hashtag
* **hashtags** - query post with specific hashtags, delimited by coma
* **type** - currently, we support four types of posts: image, weblink, videoBroadcast and video. Specifying the type will only return that type of posts. If skipped, any type of posts will be returned.
* **include** - include additional data, currently, only 'owner' is supported. This will return poster data too.
* **limit** - the maximum number of results (records) to return. Default is 100.
* **skip** - the specified number of returned records to skip, which is useful to paginate responses. Default is 0.
* ordering paramters:
  * **descending** - available values: "createdAt", "updatedAt", "likeCount"
  * **ascending** - avavilable values: "createdAt", "updatedAt", "likeCount"
  * if not specified, then by default, it's ordered by "createdAt" descending order, i.e., "descending=createdAt"

*Examples*
```
/public/api/v0/posts?access_token=[token]&limit=50&hashtag=welcome&descending=createdAt
/public/api/v0/posts?access_token=[token]&limit=50&hashtags=welcome,annualmeetings&skip=50&ascending=createdAt
/public/api/v0/posts?access_token=[token]&limit=50&skip=50&ascending=createdAt&type=image
/public/api/v0/posts?access_token=[token]&limit=50&skip=50&ascending=createdAt&type=image&include=owner
```
### Sample Response JSON
The API will return an array of JSON object. Note that, there could be additional meta data for specific type of posts. Here is a sample response:
```
[
  {
    "id": "5553e0b4af697c1d70733b87",
    "description": "#welcome to Crazy Ben",
    "numLikes": 0,
    "createdAt": "2015-05-13T23:39:32.514Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/4d592cb0-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193845LARGE.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/4d592cb0-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193845LARGE-medium.jpg",
    "type": "image"
  },
  {
    "id": "5553e0ddaf697c1d70733b89",
    "description": "#hoedown deployment goodies",
    "numLikes": 0,
    "createdAt": "2015-05-13T23:40:13.440Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/59ee9c30-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193946LARGE.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/59ee9c30-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193946LARGE-medium.jpg",
    "type": "weblink",
    "meta": {
      "title": "Elon Musk Has Good News For Tesla Fans",
      "url": "http://abcnews.go.com/Technology/elon-musk-good-news-tesla-fans/story?id=33507368",
      "faviconUrl": "(favicon url, if any)"
    }
  },
  {
    "id": "5553e6a9af697c1d70733bc4",
    "description": "[Test_Scenario_May_13,_2015_8:07_PM] #eligendi #et et #porro repellendus ##quia voluptates ##doloremque odit\nreprehenderit #dicta #est ####tempore molestiae #error est ###sint\nrepudiandae #voluptatem #velit #excepturi #eveniet #labore et iusto\ndolorem #provident ipsa ###vel #####nihil #molestias @Daryl Franecki rerum #sit #dolorum\nnumquam sit ##cumque inventore sit #minima #tenetur #id\nofficia delectus ##iure quis",
    "numLikes": 5,
    "createdAt": "2015-05-14T00:04:57.989Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/dae5b7d0-f9cc-11e4-bcc5-114b056a7c6a/foko-acceptance-test-large.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/dae5b7d0-f9cc-11e4-bcc5-114b056a7c6a/foko-acceptance-test-medium.jpg",
    "type": "videoBroadcast|video",
    "meta": {
      "url": "(url from aws s3 bucket)",
      "duration": 300 (in seconds)
    },
    "ownerFirstName": "John",
    "ownerLastName": "Down",
    "ownerProfileURL": "PROFILE_URL",
    "ownerAvatarURL": "AVATAR_IMAGE_URL"
  }
]
```
