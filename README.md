#opensearch_dedecms_plugin

## Features
1. Sync post to opensearch when edit/add/remove a post (在添加/编辑/删除post的时候自动同步opensearch)
1. Completelly supports dedecms Simple search and Advance search(支持dedecms的简单搜索和高级搜索)
1. Fully dedecms native view(完全使用dedecms的原生显示方式)

## Instalation
1. Create options table(创建options表)
	```
	DROP TABLE IF EXISTS `opensearch_for_dedecms`;
CREATE TABLE IF NOT EXISTS `opensearch_for_dedecms` ( 
`id` int(4) NOT NULL auto_increment, 
`options` varchar(256) CHARACTER SET utf8 NOT NULL,
PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	```
	
2. Add Menu(添加菜单)
	```
	INSERT INTO `dede_plus` (`plusname`, `menustring`, `mainurl`, `writer`, `isshow`, `filelist`) VALUES 
('Open Search', '<m:item name=''Open Search'' link=''/../opensearch_core/views/options.php'' rank=''plus_OpenSearch'' target=''main'' />', '', 'Aliopoensearch', 1, ''); 
	```
	
3. Copy folder 'opensearch_core' to dedecms root directory(拷贝文件夹'opensearch_core'到dedecms的根目录)
4. Add configuration file:(添加配置文件)
	```
	Add  ' require_once(dirname(__FILE__).'/../opensearch_core/config.php'); ' in the top of '/dede/config.php'
	将代码' require_once(dirname(__FILE__).'/../opensearch_core/config.php'); '添加到'/dede/config.php'顶部
	```
5. Enable post index (启用自动同步)
	```
	Add ' doIndex(get_defined_vars()); ' after 'ClearMyAddon($arcID, $title);' of file '/dede/article_add.php' and '/dede/article_edit.php'
	在 '/dede/article_add.php' and '/dede/article_edit.php'中的代码'ClearMyAddon($arcID, $title);' 之后添加 ' doIndex(get_defined_vars()); '
	
	Add ' removeIndex($aid); ' after ' DelArc($aid); ' of file '/dede/archives_do.php '
	在 '/dede/archives_do.php '的代码' DelArc($aid); '之后添加 ' removeIndex($aid); ' 
	
	```
6. Enable search supportting(开启检索支持)
	```
	 Add ' require_once(dirname(__FILE__)."/../opensearch_core/config.php"); ' in the top of file ' /include/arc.searchview.class.php '
	 在文件 ' /include/arc.searchview.class.php '顶部添加' require_once(dirname(__FILE__)."/../opensearch_core/config.php"); ' 
	 
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
7.  Open opensearch options page and put your valid account info, then justs enjoy it!(打开opensearch的设置页面，设置好您的opensearch账号信息，至此总算把opensearch集成完毕)