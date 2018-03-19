create database if not exists budget character set utf8 collate utf8_unicode_ci;
use budget;

grant all privileges on budget.* to 'budget_user'@'localhost' identified by 'secret';