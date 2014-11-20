Foko PhotoFeed WordPress Widget
-------------------------------

**IMPORTANT:** You need to install a self hosted version of wordpress in order to install this plugin (e.g. use wordpress.org instead of wordpress.com). Please update to the latest version of your browser in order to experience the full functionality of this widget.

**Before you start:** 
<p>
If you do not already have an Access Token for your company, please send an email to the following link to obtain one:
<a href="mailto:api@foko.co?Subject=Request%20Access%20Token" target="_top">
api@foko.co</a>. In the email please provide your company name and the name of the widget that you are trying to use.
</p>

**Installtion Steps:**

1. Download the zip file from https://github.com/FoKo/api/archive/master.zip.

2. Extract the zip file to your desktop, go to your newly extracted folder and locate the "photofeed" folder from the address: /api-master/widgets/wordpress

3. With your FTP program (e.g Yummy FTP for Mac or FileZilla for Windows), upload the "photofeed" folder to the wordpress/wp-content/plugins folder in your WordPress directory online.

4. Login to wordpress, navigate to Admin page -> Plugins

5. Activate Foko Widget from the list of installed plugins
  
  ![readme screenshot 1](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/Foko%20Widget%20Readme%201.png)

6. Now navigate to Appearance -> Widgets and add the Foko widget to the Content sidebar just like any other widgets (This widget is designed specifically for the sidebar, If you want to place it to other widget areas please adjust the space accordingly to allow enough room for the widget)

7. Expand the newly added widget to open the config page

8. click the "Get Access Token" link to send an email request for your Access Token if you do not already have one. You will need to provide your company name and the name of the widget that you are trying to use. (e.g. photofeed)

9. Modify the configurations:

  - Title: You can enter the title of the widget here, or leave the title blank and it will be left empty.

  - Description: Enter any custom text input, it will be displayed just below the title and before the photos.
  
  - Access Token: enter your obtained Access Token here otehrwise no photos will be displayed.
  
  - Number of photos to be displayed: enter a number between 1 to 40, this specifies the number of photos to be displayed by the widget. The default value is 20 if you leave it empty.
  
  - This widget by default displays the most recent photos from across your company. You can alternately display by:
  
    - hashtags: if you want to display photos for a specific hashtag, please enter it here with the format: #hashtag. Note: only one value is supported for now.

    - user email: if you want to display photos from a specific user, please enter his/her foko email here.
    
    Note: if you enter both of the hashtag and email values, the widget will try to find photos that satisfy both constraints.
    
    Note 2: if you leave both of the fields blank, the widget will display the most recent company photo feeds by default.

  ![readme screenshot 2](https://files.foko.co/Foko%20PhotoFeed%20Wordpress%20Widget/Readme%20Pictures/Foko%20Widget%20Readme%202.png)
