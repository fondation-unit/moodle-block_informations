# block_informations

Moodle block plugin displaying license informations.

## Settings :

Basic settings :

| Setting name    | Description                                                              |
| --------------- | ------------------------------------------------------------------------ |
| default_licence | the licence displayed in the block by default                            |
| image           | upload an image to be displayed in the block                             |
| image_url       | use a remote image url to be displayed in the block ; override the image |
| image_alt       | the alternative text of the image                                        |
| body            | the body text of the block                                               |


The block's settings has a link to a settings page for the licences [blocks/informations/configure.php](#) :

| Form item name       | Description                                 |
| -------------------- | ------------------------------------------- |
| cc_licence_name      | the name of the licence                     |
| cc_licence_url       | the url of the licence                      |
| cc_image_url         | the url of the licence image                |
| available_categories | the categories in which the license applies |
