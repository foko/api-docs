Foko's PhotoFeed Widget
-------------------------------

This is a widget that displays your comapny's photofeeds on your website.

#####Send questions and suggestions to <a href="mailto:support@foko.co" target="_top">support@foko.co.</a>
-------------------------------

**Before you start:** 
<p>
If you do not already have an Access Token for your company, please send an email to the following link to obtain one:
<a href="mailto:api@foko.co?Subject=Request%20Access%20Token" target="_top">
api@foko.co</a>. In the email please provide your company name and that you want a key for the iframe/Embed Photo Feed Widget.
</p>

**How to use**

There are two versions of this widget: the **Slide Show** and **Grid View**.

Slide Show:

![readme screenshot 1](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/foko-general-widget-readme-1.png)

The slide show version is an iframe web widget, to use it, simply copy the following code to your html markup:

        <iframe id="foko-widget" src="https://fokowidgets.parseapp.com/widgets/photofeed/foko-widget-slide.html?width=320&height=360&data-access-token=K&data-display-method=slide&data-number-photos=&data-user-email=&data-hashtag=" width="320px" height="360px" frameborder="0" scrolling="no"></iframe>
 
For example this is the html markup for the above blog website:

	<!-- Side Widget -->
	<div class="sidebar">
	    <iframe id="foko-widget" src="https://fokowidgets.parseapp.com/widgets/photofeed/foko-widget-slide.html?width=320&height=360&data-access-token=&data-display-method=slide&data-number-photos=&data-user-email=&data-hashtag=&data-show-likes=&data-show-description=" width="320px" height="360px" frameborder="0" scrolling="no"></iframe>
	</div>

You can insert this snippet anywhere in your html page but keep in mind that this is an iframe, so you will have to adjust the dimensions of the iframe manually to fit in your parent div.

Configuration parameters:
You can configure the widget by chaning the query strings, just enter the input valuse right after the "=" sign without any spaces.

- width (query string): set the width of the photo in px.

- width (iframe attribute): set the widthof the iframe in px.

- height (query string): set the max height of the photo in px.

- height (iframe attribute): set the height of the iframe in px.

- data-access-token: enter your Access Token here, or no photos will be displayed.

- data-number-photos: enter a number between 1 to 40, this specifies the number of photos to be displayed by the widget. The default value is 20 if you leave it empty.

- This widget by default displays the most recent photos from across your company. You can alternately display by changing:
  
   - data-hashtag: if you want to display photos for a specific hashtag, please enter it here with the format: hashtag. Note: only one value is supported for now.

   - data-user-email: if you want to display photos from a specific user, please enter his/her foko email here.

-------------------------------

Grid View:

![readme screenshot 2](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/foko-general-widget-readme-2.png)

The gird view version is an embedded web widget, to use it please copy the following javascript code to your html markup where you want the widget to appear:
Note: the javascript will append the widget to the parent div of where it is being placed.

	<script type="text/javascript" src="https://fokowidgets.parseapp.com/widgets/photofeed/js/foko-widget-grid.js" id="foko-widget" data-width="" data-access-token="" data-display-method="" data-number-photos="" data-user-email="" data-hashtag="" data-display-method="grid" data-show-likes="false" data-show-description="false"></script>

Configuration parameters:

- data-width: set the width of the widget.
	- Note: for the grid view version, the width of each photo is fixed at 140px, plus 8px padding on the top left and right, so each column is 156px in width. It is recommended  to set the width as a multiple of this number. (This may change in future releases to allow customizable image width)

- data-show-likes: a boolean value, change to show or hide the number of likes of each photo.

- data-show-description: a boolean value. change to show or hide the description of each photo.

- data-access-token: enter your Access Token here, or no photos will be displayed.

- data-number-photos: enter a number between 1 to 40, this specifies the number of photos to be displayed by the widget. The default value is 20 if you leave it empty.

- This widget by default displays the most recent photos from across your company. You can alternately display by changing:
  
   - data-hashtag: if you want to display photos for a specific hashtag, please enter it here with the format: hashtag. Note: only one value is supported for now.

   - data-user-email: if you want to display photos from a specific user, please enter his/her foko email here.

