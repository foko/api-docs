Foko's PhotoFeed Widget
-------------------------------

This is an iframe web widget that displays your comapny's photofeeds on your website.

#####Send questions and suggestions to <a href="mailto:support@foko.co" target="_top">support@foko.co.</a>
-------------------------------

**Before you start:** 
<p>
If you do not already have an Access Token for your company, please send an email to the following link to obtain one:
<a href="mailto:api@foko.co?Subject=Request%20Access%20Token" target="_top">
api@foko.co</a>. In the email please provide your company name and the name of the widget that you are trying to use.
</p>

**How to use**

There are two versions of this widget: the **Slide Show** and **Grid View**.

Slide Show:

![readme screenshot 1](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/foko-general-widget-readme-1.png)

If you want to use the slide show version, copy the following iframe code to your html markup:

	<iframe id="foko-widget" src="../foko-photofeed-widget/foko-widget.html" width="px" height="px" frameborder="0" scrolling="no" data-access-token="" data-number-photos="" data-user-email="" data-hashtag="" data-display-method="slide"></iframe>
 
For example this is the html markup for the above blog website:

	<!-- Side Widget -->
	<div class="sidebar">
	    <iframe id="foko-widget" src="../foko-photofeed-widget/foko-widget.html" width="325px" height="340px" frameborder="0" scrolling="no" data-access-token="" data-number-photos="" data-user-email="" data-hashtag="" data-display-method="slide"></iframe>
	</div>

You can insert this snippet anywhere in your html page but keep in mind that this is an iframe, so you will have to adjust the dimensions of the deimensions manually to fit in your parent div.

Configuration parameters:
- width: set the width of the widget in px.

- height: set the height of the widget in px.

- data-access-token: enter your Access Token here, or no photos will be displayed.

- data-number-photos: enter a number between 1 to 40, this specifies the number of photos to be displayed by the widget. The default value is 20 if you leave it empty.

- This widget by default displays the most recent photos from across your company. You can alternately display by changing:
  
   - data-hashtag: if you want to display photos for a specific hashtag, please enter it here with the format: #hashtag. Note: only one value is supported for now.

   - data-user-email: if you want to display photos from a specific user, please enter his/her foko email here.

-------------------------------

Grid View:

![readme screenshot 2](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/foko-general-widget-readme-2.png)

If you want to use the Grid View version, copy the following code instead:

	<iframe id="foko-widget" src="../foko-photofeed-widget/foko-widget.html" width="296px" frameborder="0" scrolling="no" data-access-token="" data-number-photos="" data-user-email="" data-hashtag="" data-show-likes="true" data-show-description="true"  data-display-method="grid"></iframe>

Configuration parameters:

- width: set the width of the iframe for the grid view version.
	- Note: for the grid view version, the width of each photo is fixed at 140px, plus 8px padding on the top and right, so each column is 148px in width. It is recommended  to set the width as a multiple of this number. (This may change in future releases to allow customizable image width)

- data-show-likes: a boolean value, change to show or hide the number of likes of each photo.

- data-show-description: a boolean value. change to show or hide the description of each photo.

- data-access-token: enter your Access Token here, or no photos will be displayed.

- data-number-photos: enter a number between 1 to 40, this specifies the number of photos to be displayed by the widget. The default value is 20 if you leave it empty.

- This widget by default displays the most recent photos from across your company. You can alternately display by changing:
  
   - data-hashtag: if you want to display photos for a specific hashtag, please enter it here with the format: #hashtag. Note: only one value is supported for now.

   - data-user-email: if you want to display photos from a specific user, please enter his/her foko email here.

