SET SQL_MODE= "NO_AUTO_VALUE_ON_ZERO";
SET time_zone= "+05:30";

/* 
    Database: `socialnetwork`
*/

/* Table structure for 'users' */

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `first_name` varchar(255) NOT NULL,
    `last_name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `sign_up_date` date NOT NULL,
    `active` enum( '0', '1' ) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;