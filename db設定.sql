
/* DB作成 */
create database healthcare character set utf8;

/* DB変更 */
use healthcare;

/* TABLE作成 */
create table comment (
id int not null primary key auto_increment,
insert_uid varchar(255),
insert_date date,
message text
);

/* TABLEデータ挿入 */
insert into comment (insert_uid, insert_date, message) value
('master', '2019/10/15 8:32', '体調はけっこう良い');
insert into comment (insert_uid, insert_date, message) value
('master', '2019/10/15 10:10', '疲れた');

/* ユーザ権限付与 */
grant all on healthcare.* to healthcare_user@localhost identified by 'password';

