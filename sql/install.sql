create table cr_cars
(
 car_id int(11) NOT NULL auto_increment,
 u_id int(11) NOT NULL,
 city int(11) NOT NULL,
 year int(11) NOT NULL,
 price decimal(18,2) NOT NULL,
 torg varchar(0) default NULL,
 kuzov int(11) NOT NULL,
 probeg int(11) NOT NULL,
 engine int(11) NOT NULL,
 power int(11) NOT NULL,
 kpp int(11) NOT NULL,
 privod int(11) NOT NULL,
 color int(11) NOT NULL,
 info text DEFAULT NULL,
 photos int(11) default 0,
 PRIMARY KEY (car_id)

)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table cr_cars_photos
(
  ph_id int(11) NOT NULL auto_increment,
  car_id int(11) NOT NULL,
  path varchar(500) NOT NULL,
  PRIMARY KEY (ph_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;

create table cr_users
(
 u_id int(11) NOT NULL auto_increment,
 name varchar(300) NOT NULL,
 email varchar(300) NOT NULL,
 phone varchar(300) NOT NULL,
 PRIMARY KEY (u_id)
)
ENGINE=MyISAM  DEFAULT CHARSET=utf8;