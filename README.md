#opensearch_dedecms_plugin

## Features
1. Sync post to opensearch when edit/add/remove a post
1. Completelly supports dedecms Simple search and Advance search
1. Fully dedecms native view

## Instalation
1. Create options table
	```
	DROP TABLE IF EXISTS `opensearch_for_dedecms`;
CREATE TABLE IF NOT EXISTS `opensearch_for_dedecms` ( 
`id` int(4) NOT NULL auto_increment, 
`options` varchar(256) CHARACTER SET utf8 NOT NULL,
PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	```
	
2. Add Menu
	```
	INSERT INTO `dede_plus` (`plusname`, `menustring`, `mainurl`, `writer`, `isshow`, `filelist`) VALUES 
('Open Search', '<m:item name=''Open Search'' link=''/../opensearch_core/views/options.php'' rank=''plus_OpenSearch'' target=''main'' />', '', 'Aliopoensearch', 1, ''); 
	```
	
3. Copy folder 'opensearch_core' to dedecms root directory
4. Add configuration file:
	```
	Add  ' require_once(dirname(__FILE__).'/../opensearch_core/config.php'); ' in the top of '/dede/config.php'
	```
5. Enable post index
	```
	Add ' doIndex(get_defined_vars()); ' after 'ClearMyAddon($arcID, $title);' of file '/dede/article_add.php' and '/dede/article_edit.php'
	Add ' removeIndex($aid); ' after ' DelArc($aid); ' of file '/dede/archives_do.php '
	```
6. Enable search supportting
	```
	 Add ' require_once(dirname(__FILE__)."/../opensearch_core/config.php"); ' in the top of file ' /include/arc.searchview.class.php '
	 Change ' if ($cfg_sphinx_article == 'Y') ' to:
	 
	  $options = new \OpensearchOptionValues();

        if ($options->isValid) {
            $searchResult = doOpensearch(get_defined_vars(),$this->KType,$this->SearchType,$this->Keywords);

            foreach ($searchResult['result']['items'] as $item) {
                $aids[] = intval($item['id']);
            }

            $aids = @implode(',', $aids);

            $this->TotalResult = isset($aids) ? count($aids) : 0;
            $this->TotalPage = ceil($this->TotalResult/$this->PageSize);
            $query = "SELECT arc.*,act.typedir,act.typename,act.isdefault,act.defaultname,act.namerule,
            act.namerule2,act.ispart,act.moresite,act.siteurl,act.sitepath
            FROM `#@__archives` arc LEFT JOIN `#@__arctype` act ON arc.typeid=act.id
            WHERE arc.id IN ($aids)";
        }
        else if ($cfg_sphinx_article == 'Y')
	 
	```
7.  Open opensearch options page and put your valid account info, then justs enjoy it!