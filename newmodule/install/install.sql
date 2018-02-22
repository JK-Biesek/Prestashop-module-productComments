CREATE TABLE IF NOT EXISTS `PREFIX_newmodule_comment` (
`id_newmodule_comment` int(11) NOT NULL AUTO_INCREMENT,
`id_product` int(11) NOT NULL,
`firstname` VARCHAR( 255 ) NOT NULL,
`lastname` VARCHAR( 255 ) NOT NULL,
`email` VARCHAR( 255 ) NOT NULL,
`grade` tinyint(1) NOT NULL,
 `comment` text NOT NULL,
 `date_add` datetime NOT NULL,
 primary key(`id_newmodule_comment`))
 ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
