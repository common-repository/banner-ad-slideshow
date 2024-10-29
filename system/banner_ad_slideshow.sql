CREATE TABLE `banneradslideshow` (
  `intbannerid` int(20) NOT NULL AUTO_INCREMENT,
  `varbannertitle` varchar(250) NOT NULL,
  `varbannerimage` varchar(250) NOT NULL,
  `dtadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intbannerid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
INSERT INTO `banneradslideshow` (`intbannerid`, `varbannertitle`, `varbannerimage`, `dtadded`) VALUES
(1, 'Test-1', 'Main-Banner351.jpg', '2023-06-16 10:17:05'),
(2, 'Test-2', 'Main-Banner246.jpg', '2023-06-16 17:52:48'),
(3, 'Test-3', 'featureslider13.jpg', '2023-06-16 17:43:04'),
(4, 'Test-4', 'featureslider24.jpg', '2023-06-16 17:44:36'),
(5, 'Test-5', 'featureslider35.jpg', '2023-06-16 17:46:15');

