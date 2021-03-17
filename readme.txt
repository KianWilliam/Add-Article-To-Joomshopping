Content Plugin addarticiletojshopping version 1.0.0 and user plugin adduserfoldertojce are  free softwares which is developed by
KWProductions Co.
The license is GNU/GPLv3
It is written for joomla 3.x, joomla 4 alpha and betta, 
There are some conditions to work with this plugin :
1- The plugin is designed to work with  com_jshopping, jce-editor and com_k2 , it relies on all
2-The user creates the same category structure both in k2 and jshopping, the name must be the same and children in different
 categories can not have the same name, names must be unique. In pro version, I shall add a plugin
 in such a way that as soon as a user creates a category in k2, the same would be created in jshopping automatically 
3-The user must create two extra fields in K2, first one must be for a price under the name field: K2ExtraField_1,
 second for a short description of the article, the name field K2ExtraField_2,
 In pro version it will be done automatically as soon as the main plugin is uploaded and enabled.
4-I used the manufacturer_id field of table #__jshopping products to add userid of the article writer in k2
5-I used the product_ean field(product code) of table #__jshopping_products to add article id in K2 to the related record
It is easy to alter the table and add these new fields to it but I would rather the integrity of
 the table products in jshopping remain the same.
6-The plugin works with all languages but category names must be the same as I mentioned before,
 for example, if a user writes an article in French and the name of the category in k2 is: La Science, 
 in jshopping this category with the same name must be created.
 7-To input images in the article, users would be opened to images folder by clicking image icon, to upload images and then insert their images. To improve more privacy there are different ways, because of having other projects I chose this way:
7-a: I added plugin adduserfoldertojce to add a folder in images which is the same name as username, it is for jce extension, the folder is added to images folder
7-b: All new users are under publisher group or you can create a group under register and give that group the related actions
7-c: I employed jce editor and made it default editor, in profile section I added images/$username for file directory
So my extension now relys on 3 extensions: 1-jshopping 2-jce-editor 3-k2
now when a user click on image icon in jce-editor of k2 to add an image to article, it will be opened only to his own private folder under images,
3- I wrote french articles and when I checked them in jshopping, french part was added, but the item did not have any name and explanantion,
because the English field was empty, that is why in any language, I fill English fields so that the item product will be editable
I acted so fast for this plugin on account of other projects, I shall do more tests and in case of any change I let you know
8-In Pro versions an article writer could upload a zip file with related 
images but this one is basic, the user must type or copy and paste the article with related images.

you may download the extension @:
https://www.extensions.kwproductions121.com/myplugins/add-artucke-to-jshopping.html
In case of any problem contact me at:
webarchitect@kwproductions121.com
https://github.com/KianWilliam/addarticletojshopping.git
long live science.
