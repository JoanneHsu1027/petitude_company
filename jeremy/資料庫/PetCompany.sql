-- try full titanic data
create database if not exists PetCompany ;
use PetCompany;
-- drop database petcompany;
#　　　共用資料庫　　　#


#縣市列表
CREATE TABLE IF NOT EXISTS county(
  county_id int not null primary key auto_increment,
  county_name nvarchar(10)
 );
 
#鄉鎮市區列表
CREATE TABLE IF NOT EXISTS city(
  city_id int not null primary key auto_increment,
  city_name nvarchar(10),
  fk_county_id int,
  foreign key(fk_county_id) references county(county_id),
  postal_code varchar(10)
 );

#員工權限
CREATE TABLE IF NOT EXISTS b2b_job(
  b2b_job_id int not null primary key auto_increment,
  b2b_job_name nvarchar(50),
  b2b_permissions int
 );

 #後臺員工
CREATE TABLE IF NOT EXISTS b2b_members(
  b2b_id int not null primary key auto_increment,
  b2b_account VARCHAR(50),
  b2b_password VARCHAR(255),
  b2b_name nvarchar(50),
  b2b_email nvarchar(50),
  b2b_mobile char(10),
  fk_b2b_job_id int,
  foreign key(fk_b2b_job_id) references b2b_job(b2b_job_id) ON DELETE CASCADE
 );

#前台會員
CREATE TABLE IF NOT EXISTS b2c_members(
  b2c_id int not null primary key auto_increment,
  b2c_name nvarchar(50),
  b2c_email NVARCHAR(50),
  b2c_password VARCHAR(50),
  b2c_birth date,
  b2c_mobile char(10),
  b2c_avatar varchar(255),
  fk_county_id int,
  foreign key(fk_county_id) references county(county_id),
  fk_city_id int,
  foreign key(fk_city_id) references city(city_id),
  b2c_address nvarchar(255),
  b2c_IDcard nvarchar(18)
 );
 
 #寵物資料
 CREATE TABLE IF NOT EXISTS pet(
  pet_id int not null primary key auto_increment,
  pet_chip char(15),
  pet_name NVARCHAR(20),
  pet_sex varchar(10),
  pet_birth date,
  pet_type tinyint,
  pet_breed varchar(50),
  fk_b2c_id int,
  foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE
 );
 
 
#　　　特定資料庫　　　#


#　－－論壇Start－－　#

-- 主題分類
create table IF NOT EXISTS class(
class_id int auto_increment primary key,
class_name varchar (50),
fk_b2b_id int,
foreign key(fk_b2b_id) references b2b_members(b2b_id) ON DELETE CASCADE
);

-- 文章列表
create table IF NOT EXISTS article(
article_id int auto_increment primary key,
article_date datetime,
article_name nvarchar(50),
article_content nvarchar(1000),
article_img nvarchar(100),
fk_class_id int,
foreign key(fk_class_id) references class(class_id) ON DELETE CASCADE,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE
);

-- 文章留言
create table IF NOT EXISTS message(
message_id int auto_increment primary key,
message_content nvarchar (200),
message_date datetime,
message_img nvarchar (100),
fk_article_id int,
foreign key(fk_article_id) references article(article_id) ON DELETE CASCADE,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE
);

-- 留言回覆
create table IF NOT EXISTS re_message(
re_message_id int auto_increment primary key,
re_message_content nvarchar(200),
re_message_date datetime,
re_message_img nvarchar(100),
fk_message_id int,
foreign key(fk_message_id) references message(message_id) ON DELETE CASCADE,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE
);

-- 文章收藏列表
create table IF NOT EXISTS favorite(
favorite_id int auto_increment primary key,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE,
fk_article_id int,
foreign key(fk_article_id) references article(article_id) ON DELETE CASCADE
);
#　－－論壇End－－　#

#　－－生命禮儀Start－－　#
-- 預約參觀
create table IF NOT EXISTS reservation(
reservation_id int auto_increment primary key,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE,
fk_pet_id int,
foreign key(fk_pet_id) references pet(pet_id) ON DELETE CASCADE,
reservation_date datetime not null,
note nvarchar(500)
);


-- 生前契約
create table IF NOT EXISTS project(
project_id int auto_increment primary key,
project_level int,
project_name nvarchar(50),
project_content nvarchar(1000),
project_fee int
);

-- 契約訂單
create table IF NOT EXISTS booking(
booking_id int auto_increment primary key,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE,
fk_pet_id int,
foreign key(fk_pet_id) references pet(pet_id) ON DELETE CASCADE,
fk_project_id int,
foreign key(fk_project_id) references project(project_id) ON DELETE CASCADE,
fk_reservation_id int,
foreign key(fk_reservation_id) references reservation(reservation_id) ON DELETE CASCADE,
booking_date datetime,
booking_note nvarchar(500)
);

#　－－生命禮儀End－－　#

#　－－商品Start－－　#

-- 商品資訊
create table IF NOT EXISTS product(
product_id int auto_increment primary key,
product_name nvarchar(100),
product_description nvarchar(1000),
product_price int not null,
product_quantity int not null default '0',
product_category nvarchar(100),
product_date datetime not null,
product_last_modified datetime
);

-- 商品圖片
create table IF NOT EXISTS product_imgs(
picture_id int auto_increment primary key,
fk_product_id int,
foreign key(fk_product_id) references product(product_id) ON DELETE CASCADE,
picture_name nvarchar(50),
picture_url nvarchar(1000) not null
);


-- 訂單資訊
create table IF NOT EXISTS request(
request_id int auto_increment primary key,
request_date datetime,
request_status varchar(50) not null default '待出貨',
payment_status tinyint,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE,
request_price int,
fk_county_id int,
foreign key(fk_county_id) references county(county_id),
fk_city_id int,
foreign key(fk_city_id) references city(city_id),
recipient_address nvarchar(50),
recipient_mobile varchar(15),
recipient_email nvarchar(50)
);

-- 訂單細表
create table IF NOT EXISTS request_detail(
request_detail_id int auto_increment primary key,
fk_request_id int,
foreign key(fk_request_id) references request(request_id) ON DELETE CASCADE,
fk_product_id int,
foreign key(fk_product_id) references product(product_id) ON DELETE CASCADE,
purchase_quantity int,
comment_score int default '0',
comment_comments nvarchar(500),
comment_image nvarchar(1000)
);

#　－－商品End－－　#

#　－－保險訂單Start－－　#
-- 保險商品表
create table IF NOT EXISTS insurance_product(
insurance_product_id int auto_increment primary key,
insurance_name nvarchar(50),
insurance_fee int,
outpatient_clinic_time int,
outpatient_clinic_fee int,
Hospitalized_time int,
Hospitalized_fee int,
surgery_time int,
surgery_fee int,
max_compensation_of_medical_expense int,
personal_injury_liability int,
bodily_injury int,
property_damage int,
max_compensation_of_pet_tort int,
pet_search_advertising_expenses int,
pet_boarding_fee int,
pet_funeral_expenses int,
pet_reacquisition_cost int,
travel_cancellation_fee int
);
-- 保險訂單表
create table IF NOT EXISTS insurance_order(
insurance_order_id int auto_increment primary key,
fk_b2c_id int,
foreign key(fk_b2c_id) references b2c_members(b2c_id) ON DELETE CASCADE,
fk_pet_id int,
foreign key(fk_pet_id) references pet(pet_id) ON DELETE CASCADE,
fk_insurance_product_id int,
foreign key(fk_insurance_product_id) references insurance_product(insurance_product_id) ON DELETE CASCADE,
payment_status tinyint,
insurance_start_date date,
fk_county_id int,
foreign key(fk_county_id) references county(county_id),
fk_city_id int,
foreign key(fk_city_id) references city(city_id),
policyholder_address nvarchar(50),
policyholder_mobile varchar(15),
policyholder_email nvarchar(50),
policyholder_IDcard nvarchar(18)
);

#　－－保險訂單End－－　#

#　　　資料匯入　　　#
-- 縣市
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/county.csv'
INTO TABLE county
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(county_id,county_name);

-- 鄉鎮區
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/city.csv'
INTO TABLE city
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(city_id,fk_county_id,city_name,postal_code);
-- 前台會員
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/b2c_members.csv'
INTO TABLE b2c_members
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(b2c_id,b2c_name,b2c_email,b2c_password,b2c_birth,b2c_mobile,b2c_avatar,fk_county_id,fk_city_id,b2c_address,b2c_IDcard);

-- 寵物資料
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/pet.csv'
INTO TABLE pet
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(pet_id,pet_chip, pet_name, pet_sex, pet_birth, pet_type, pet_breed, fk_b2c_id);


-- 保險產品 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/insurance_product.csv'
INTO TABLE insurance_product
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(insurance_product_id,insurance_name,insurance_fee,outpatient_clinic_time,outpatient_clinic_fee,Hospitalized_time,Hospitalized_fee,surgery_time,surgery_fee,max_compensation_of_medical_expense,personal_injury_liability,bodily_injury,property_damage,max_compensation_of_pet_tort,pet_search_advertising_expenses,pet_boarding_fee,pet_funeral_expenses,pet_reacquisition_cost,travel_cancellation_fee);

-- 保險訂單 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/insurance_order.csv'
INTO TABLE insurance_order
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(insurance_order_id,fk_b2c_id,fk_pet_id,fk_insurance_product_id,payment_status,insurance_start_date,fk_county_id,fk_city_id,policyholder_address,policyholder_mobile,policyholder_email,policyholder_IDcard);

-- 預約參觀 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/reservation.csv'
INTO TABLE reservation
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(reservation_id,fk_b2c_id,fk_pet_id,reservation_date,note);

-- 生前契約 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/project.csv'
INTO TABLE project
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(project_id,project_level,project_name,project_content,project_fee);

-- 契約訂單 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/booking.csv'
INTO TABLE booking
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(booking_id,fk_b2c_id,fk_pet_id,fk_project_id,fk_reservation_id,booking_date,booking_note);

-- 商品資訊 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/product.csv'
INTO TABLE product
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(product_id,product_name,product_description,product_price,product_quantity,product_category,product_date,product_last_modified);

-- 商品圖片 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/productIMG.csv'
INTO TABLE product_imgs
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(picture_id,fk_product_id,picture_name,picture_url);

-- 訂單資訊 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/request.csv'
INTO TABLE request
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(request_id,request_date,request_status,payment_status,fk_b2c_id,request_price,fk_county_id,fk_city_id,recipient_address,recipient_mobile,recipient_email);

-- 訂單詳細 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/request_detail.csv'
INTO TABLE request_detail
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(request_detail_id,fk_request_id,fk_product_id,purchase_quantity,comment_score,comment_comments,comment_image);
-- 員工權限 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/b2b_job.csv'
INTO TABLE b2b_job
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(b2b_job_id,b2b_job_name,b2b_permissions);

-- 後臺員工 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/b2b_members.csv'
INTO TABLE b2b_members
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(b2b_id,b2b_account,b2b_password,b2b_name,b2b_email,b2b_mobile,fk_b2b_job_id);

show warnings;

-- 主題分類 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/class.csv'
INTO TABLE class
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(class_id,class_name,fk_b2b_id);

-- 文章列表 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/article.csv'
INTO TABLE article
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(article_id,article_date,article_name,article_content,article_img,fk_class_id,fk_b2c_id);

-- 文章留言 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/message.csv'
INTO TABLE message
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(message_id,message_content,message_date,message_img,fk_article_id,fk_b2c_id);

-- 留言回覆 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/re_message.csv'
INTO TABLE re_message
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(re_message_id,re_message_date,re_message_content,re_message_img,fk_message_id,fk_b2c_id);

-- 文章收藏列表 --
LOAD DATA
INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/favorite.csv'
INTO TABLE favorite
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(favorite_id,fk_b2c_id,fk_article_id);

