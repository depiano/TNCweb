create database tnc_db;
use tnc_db;


CREATE TABLE `amministratore` (
  `Email` varchar(25) NOT NULL,
  `Fullname` varchar(25) NOT NULL,
  `Phone` varchar(13) NOT NULL,
  `Password` varchar(20) NOT NULL,
  primary key(Email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `operatore` (
  `Email` varchar(25) NOT NULL,
  `Fullname` varchar(25) NOT NULL,
  `Phone` varchar(13) NOT NULL,
  `Password` varchar(20) NOT NULL,
  primary key(Email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `censimento` (
  `Longitudine` varchar(20) NOT NULL,
  `Latitudine` varchar(20) NOT NULL,
  `Civico` int(11) NOT NULL,
  `Dug` varchar(10) NOT NULL,
  `Denominazione` varchar(25) NOT NULL,
  `Esponente` varchar(10) NOT NULL,
  `PathFotoCivico` varchar(50) NOT NULL,
  `PathFotoAbitazione` varchar(50) NOT NULL,
  `EmailOperatore` varchar(25) NOT NULL,
  `EmailAmministratore` varchar(25) NOT NULL,
  FOREIGN KEY (EmailOperatore) REFERENCES operatore(Email),
   FOREIGN KEY (EmailAmministratore) REFERENCES amministratore(Email),
  primary key(Longitudine, Latitudine, Civico)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
