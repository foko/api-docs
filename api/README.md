# Foko public API (V0)

## Retrieve Company's Photo Stream
This public api retrieves all photo posts for your company with Foko system. Note that album photos are included as individual posts.
### Url Endpoint
```
GET https://api.foko.io/public/api/v0/posts
```
### Query Paramters
* **access_token** - (required) please request a access token by contacting Foko support 'api@foko.co'
* **hashtag** - query posts with specific hashtag
* **hashtags** - query post with specific hashtags, delimited by coma
* **include** - include additional dependent objects. Use comma to separate them, for example, "include=owner,comments,likes"
  * **owner** including posting user data, such as firstName, lastName and avatar
  * **comments** including available comments for this post
  * **likes** including available likes
* **limit** - the maximum number of results (records) to return. Default is 100, but max is 500. 
* **type** - (DEPRECATED) By default, always return "image" type post, including individual photos in albums.
* **skip** - the specified number of returned records to skip, which is useful to paginate responses. Default is 0.
* specify timestamp range for search "createdAt" or "touchedAt", specified by "ordering". For example, if ordering is "createdAt" (default), searching is against post creation time; if ordering is "touchedAt", searching is against "touchedAt" which records last commenting or liking timestamp on this post.
  * **from** - start time in UTC, for example, "2016-04-01", or "2016-03-23 21:22:45.780Z"
  * **to** - end time in UTC, for example, "2016-04-01", or "2016-03-23 21:22:45.780Z"
* ordering paramters:
  * **descending** - available values: "createdAt", "touchedAt"
  * **ascending** - avavilable values: "createdAt", "touchedAt"
  * if not specified, then by default, it's ordered by "createdAt" descending order, i.e., "descending=createdAt"

*Examples*
```
/public/api/v0/posts?access_token=[token]&limit=50&hashtag=welcome&descending=createdAt
/public/api/v0/posts?access_token=[token]&limit=50&hashtags=welcome,annualmeetings&skip=50&ascending=createdAt
/public/api/v0/posts?access_token=[token]&limit=50&skip=50&ascending=touchedAt
/public/api/v0/posts?access_token=[token]&limit=50&skip=50&ascending=touchedAt&include=owner,comments
/public/api/v0/posts?access_token=[token]&limit=50&skip=50&ascending=touchedAt&include=owner,comments,likes&from=2016-03-01&to=2016-03-15
```
### Sample Response JSON
The API will return an array of JSON object. Here is a sample response:
```
[
  {
    "id": "5553e0b4af697c1d70733b87",
    "content": "#welcome to Crazy Ben",
    "numLikes": 0,
    "numComments": 0,
     "createdAt": "2015-05-11T23:40:13.440Z",
    "touchedAt": "2015-05-11T23:40:14.440Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/4d592cb0-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193845LARGE.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/4d592cb0-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193845LARGE-medium.jpg",
    "type": "image"
  },
  {
    "id": "5553e0ddaf697c1d70733b89",
    "content": "#hoedown deployment goodies",
    "numLikes": 2,
    "numComments": 0,
    "createdAt": "2015-05-13T23:40:13.440Z",
    "touchedAt": "2015-05-14T23:40:13.440Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/59ee9c30-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193946LARGE.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/59ee9c30-f9c9-11e4-bcc5-114b056a7c6a/Photo_20150513_193946LARGE-medium.jpg",
    "type": "image"
  },
  {
    "id": "5553e6a9af697c1d70733bc4",
    "content": "[Test_Scenario_May_13,_2015_8:07_PM] #eligendi #et et #porro repellendus ##quia voluptates ##doloremque odit\nreprehenderit #dicta #est ####tempore molestiae #error est ###sint\nrepudiandae #voluptatem #velit #excepturi #eveniet #labore et iusto\ndolorem #provident ipsa ###vel #####nihil #molestias @Daryl Franecki rerum #sit #dolorum\nnumquam sit ##cumque inventore sit #minima #tenetur #id\nofficia delectus ##iure quis",
    "numLikes": 1,
    "numComments": 2,
    "createdAt": "2015-05-14T00:04:57.989Z",
    "touchedAt": "2015-06-14T00:04:57.989Z",
    "largeImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/dae5b7d0-f9cc-11e4-bcc5-114b056a7c6a/foko-acceptance-test-large.jpg",
    "mediumImgURL": "https://s3.amazonaws.com/foko-media/playground/image/post/dae5b7d0-f9cc-11e4-bcc5-114b056a7c6a/foko-acceptance-test-medium.jpg",
    "type": "image",
    "ownerFirstName": "John",
    "ownerLastName": "Down",
    "ownerProfileURL": "PROFILE_URL",
    "ownerAvatarURL": "AVATAR_IMAGE_URL",
    "comments": [
      {
        "id": "58417b672ab1b5469a999e98",
        "type": "text",
        "content": "Looks great!",
        "createdAt": "2016-12-02T13:47:19.248Z",
        "touchedAt": "2016-12-02T13:47:19.263Z",
        "ownerFirstName": "Sylvia",
        "ownerLastName": "Schade",
        "ownerUsername": "sylvia.schade@foko.co",
        "ownerProfileURL": "PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      },
      {
        "id": "58417b8a2ab1b5469a999e9b",
        "type": "image",
        "content": "Looks a bit empty",
        "createdAt": "2016-12-02T13:47:54.487Z",
        "touchedAt": "2016-12-02T13:47:54.499Z",
        "ownerFirstName": "Sylvia",
        "ownerLastName": "Schade",
        "ownerUsername": "sylvia.schade@foko.co",
        "ownerProfileURL": "PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ],
    "likes": [
      {
        "id": "58417b5b0f530f3f91131eab",
        "createdAt": "2016-12-02T13:47:07.336Z",
        "ownerFirstName": "Sylvia",
        "ownerLastName": "Schade",
        "ownerUsername": "sylvia.schade@foko.co",
        "ownerProfileURL": "PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ]
  }
]
```

## Retrieve Company's Photo Feed
This public api mimics Foko client feed where album photos are embeded in album post. Commenting will push a feed post to the top, but liking will not.
### Url Endpoint
```
GET https://api.foko.io/public/api/v0/feed
```
### Query Paramters
* **access_token** - (required) please request a access token by contacting Foko support 'api@foko.co'
* **channelId** - If provided, only photos from the specified channel will be returned, otherwise, photos from all public channels of your company will be returned. Please request channelId from Foko support.
* **include** - include additional dependent objects. Use comma to separate them, for example, "include=comments,likes". Note that for this api, "owner" will always be included.
  * **comments** including available comments for this post
  * **likes** including available likes
* **limit** - the maximum number of results (records) to return. Default is 100, but max is 500. 
* **skip** - the specified number of returned records to skip, which is useful to paginate responses. Default is 0.
* specify timestamp range for search "createdAt" or "pokedAt", specified by "ordering". For example, if ordering is "createdAt" (default), searching is against post creation time; if ordering is "touchedAt", searching is against "touchedAt" which records last commenting or liking timestamp on this post.
  * **from** - start time in UTC, for example, "2016-04-01", or "2016-03-23 21:22:45.780Z"
  * **to** - end time in UTC, for example, "2016-04-01", or "2016-03-23 21:22:45.780Z"
* ordering paramters:
  * **descending** - available values: "createdAt", "pokedAt"
  * **ascending** - avavilable values: "createdAt", "pokedAt"
  * if not specified, then by default, it's ordered by "pokedAt" descending order, i.e., "descending=pokedAt"
  * use "pokedAt" to reflect feed post timestamp changes caused by commenting.
*Examples*
```
/public/api/v0/feed?access_token=[token]&limit=0&skip=50&channelId=58417b5b0f530f3f91131FFF
/public/api/v0/feed?access_token=[token]&limit=50&skip=50&ascending=pokedAt
/public/api/v0/feed?access_token=[token]&limit=50&skip=50&ascending=pokedAt&include=comments,likes
/public/api/v0/feed?access_token=[token]&limit=50&skip=50&ascending=pokedAt&include=comments,likes&from=2016-03-01&to=2016-03-15
```
### Sample Response JSON
The API will return an array of JSON object. Here is a sample response:
```
[
  {
    "id": "5553e0b4af697c1d70733b87",
    "content": "#welcome to Foko",
    "numLikes": 0,
    "numComments": 0,
    "createdAt": "2015-05-11T23:40:13.440Z",
    "touchedAt": "2015-05-11T23:40:14.440Z",
    "pokedAt": "2015-05-11T23:40:14.440Z",
    "largeImgURL": "IMAGE_URL",
    "mediumImgURL": "IMAGE_URL",
    "type": "image",
    "ownerFirstName": "FirstName1",
    "ownerLastName": "LastName1",
    "ownerUsername": "USERNAME1",
    "ownerProfileURL": "FOKO_PROFILE_URL",
    "ownerAvatarURL": "AVATAR_IMAGE_URL",
    "channelName": "General"
  },
  {
    "id": "5553e0ddaf697c1d70733b89",
    "content": "Please plank, good for you!",
    "numLikes": 1,
    "likes": [
      {
        "id": "58417b5b0f530f3f91131eab",
        "createdAt": "2016-12-02T13:47:07.336Z",
        "ownerFirstName": "FirstName2",
        "ownerLastName": "LastName2",
        "ownerUsername": "USER_NAME",
        "ownerProfileURL": "FOKO_PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ],
    "numComments": 1,
    "comments": [
      {
        "id": "58417b5b0f530f3f911adfab",
        "content": "thank you!",
        "createdAt": "2016-12-02T13:47:07.336Z",
        "ownerFirstName": "FirstName2",
        "ownerLastName": "LastName2",
        "ownerUsername": "USER_NAME",
        "ownerProfileURL": "FOKO_PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ],
    "createdAt": "2015-05-13T23:40:13.440Z",
    "touchedAt": "2015-05-14T23:40:13.440Z",
    "pokedAt": "2015-05-14T23:40:13.440Z",
    "largeImgURL": "IMAGE_URL",
    "mediumImgURL": "IMAGE_URL",
    "type": "image",
    "ownerFirstName": "FirstName1",
    "ownerLastName": "LastName1",
    "ownerProfileURL": "FOKO_PROFILE_URL",
    "ownerAvatarURL": "AVATAR_IMAGE_URL",
    "channelName": "General"
  },
  {
    "id": "5553e6a9af697c1d707adfc4",
    "content": "What a good album!",
    "numLikes": 1,
    "numComments": 2,
    "createdAt": "2015-05-14T00:04:57.989Z",
    "touchedAt": "2015-06-14T00:04:57.989Z",
    "pokedAt": "2015-06-14T00:04:57.989Z",
    "type": "container",
    "ownerFirstName": "John",
    "ownerLastName": "Down",
    "ownerProfileURL": "FOKO_PROFILE_URL",
    "ownerAvatarURL": "AVATAR_IMAGE_URL",
    "channelName": "Best Practices",
    "comments": [
      {
        "id": "58417b672ab1b5469a999adf",
        "type": "text",
        "content": "album comment 1",
        "createdAt": "2016-12-02T13:47:19.248Z",
        "ownerFirstName": "FirstName3",
        "ownerLastName": "LastName3",
        "ownerUsername": "USERNAME3",
        "ownerProfileURL": "PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      },
      {
        "id": "58417b8a2ab1b5469a999e9b",
        "type": "text",
        "content": "album comment 2",
        "createdAt": "2016-12-02T13:47:54.487Z",
        "ownerFirstName": "FirstName4",
        "ownerLastName": "LastName4",
        "ownerUsername": "USERNAME4",
        "ownerProfileURL": "FOKO_PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ],
    "likes": [
      {
        "id": "58417b5b0f530f3f91131eab",
        "createdAt": "2016-12-02T13:47:07.336Z",
        "ownerFirstName": "FirstName5",
        "ownerLastName": "LastName5",
        "ownerUsername": "USERNAME5",
        "ownerProfileURL": "FOKO_PROFILE_URL",
        "ownerAvatarURL": "AVATAR_IMAGE_URL"
      }
    ],
    "numPhotos": 2,
    "photos": [
      {
        "id": "adf3e0b4af697c1d70733b87",
        "content": "album photo 1",
        "numLikes": 0,
        "numComments": 0,
        "createdAt": "2015-05-11T23:40:13.440Z",
        "touchedAt": "2015-05-11T23:40:14.440Z",
        "pokedAt": "2015-05-11T23:40:14.440Z",
        "largeImgURL": "IMAGE_URL",
        "mediumImgURL": "IMAGE_URL",
        "type": "image"
      },
      {
        "id": "5553e0ddaf6adf1d70733b89",
        "content": "album photo 2",
        "createdAt": "2015-05-13T23:40:13.440Z",
        "touchedAt": "2015-05-14T23:40:13.440Z",
        "pokedAt": "2015-05-14T23:40:13.440Z",
        "largeImgURL": "IMAGE_URL",
        "mediumImgURL": "IMAGE_URL",
        "type": "image",
        "numLikes": 1,
        "likes": [
          {
            "id": "58417b5b0f530f3adf131eab",
            "createdAt": "2016-12-02T13:47:07.336Z",
            "ownerFirstName": "FirstName2",
            "ownerLastName": "LastName2",
            "ownerUsername": "USER_NAME",
            "ownerProfileURL": "FOKO_PROFILE_URL",
            "ownerAvatarURL": "AVATAR_IMAGE_URL"
          }
        ],
        "numComments": 1,
        "comments": [
          {
            "id": "58417b5b0f5adf3f91131eab",
            "content": "album photo comment 1",
            "type": "text",
            "createdAt": "2016-12-02T13:47:07.336Z",
            "ownerFirstName": "FirstName2",
            "ownerLastName": "LastName2",
            "ownerUsername": "USER_NAME",
            "ownerProfileURL": "FOKO_PROFILE_URL",
            "ownerAvatarURL": "AVATAR_IMAGE_URL"
          }
        ]
      }
    ]
  }
]
```
