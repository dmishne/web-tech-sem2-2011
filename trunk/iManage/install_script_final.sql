-- Script date 1/2/2012 12:07:54 AM
-- Server version: 5.0.85
-- Client version: 4.1

-- 
-- Disable foreign keys
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Set character set the client will use to send SQL statements to the server
--
SET NAMES 'utf8';

--
-- Definition for database webtechtest
--
DROP DATABASE IF EXISTS webtechtest;
CREATE DATABASE IF NOT EXISTS webtechtest
	CHARACTER SET latin1
	COLLATE latin1_swedish_ci;

-- 
-- Set default database
--
USE webtechtest;

--
-- Definition for table commitdailyjoblog
--
CREATE TABLE IF NOT EXISTS commitdailyjoblog (
  commitDailyJobLogId INT(11) NOT NULL AUTO_INCREMENT,
  runDate DATETIME NOT NULL,
  isSuccessful INT(11) NOT NULL DEFAULT 0,
  jobName VARCHAR(255) NOT NULL,
  PRIMARY KEY (commitDailyJobLogId)
)
ENGINE = INNODB
AUTO_INCREMENT = 30
AVG_ROW_LENGTH = 1260
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Definition for table permission
--
CREATE TABLE IF NOT EXISTS permission (
  permissionId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  description VARCHAR(45) NOT NULL,
  name VARCHAR(45) NOT NULL,
  PRIMARY KEY (permissionId)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table recurrencetype
--
CREATE TABLE IF NOT EXISTS recurrencetype (
  recurTypeId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  type VARCHAR(45) NOT NULL,
  PRIMARY KEY (recurTypeId)
)
ENGINE = INNODB
AUTO_INCREMENT = 11
AVG_ROW_LENGTH = 2730
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table transactiontype
--
CREATE TABLE IF NOT EXISTS transactiontype (
  typeId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  Name VARCHAR(45) NOT NULL,
  Description VARCHAR(45) NOT NULL,
  PRIMARY KEY (typeId)
)
ENGINE = INNODB
AUTO_INCREMENT = 8
AVG_ROW_LENGTH = 2730
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table userstatus
--
CREATE TABLE IF NOT EXISTS userstatus (
  statusId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(100) NOT NULL,
  PRIMARY KEY (statusId)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table wallettype
--
CREATE TABLE IF NOT EXISTS wallettype (
  typeId INT(10) NOT NULL AUTO_INCREMENT,
  typeName VARCHAR(45) NOT NULL,
  PRIMARY KEY (typeId)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table users
--
CREATE TABLE IF NOT EXISTS users (
  userId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  loginname VARCHAR(20) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  lastName VARCHAR(20) DEFAULT NULL,
  registrationDate DATETIME NOT NULL,
  dateOfBirth DATE NOT NULL,
  statusId INT(10) UNSIGNED NOT NULL,
  permissionId INT(10) UNSIGNED NOT NULL,
  email VARCHAR(45) NOT NULL,
  pincode VARCHAR(45) NOT NULL,
  statusChangeDate DATETIME DEFAULT NULL,
  statusChangeComment VARCHAR(225) DEFAULT NULL,
  PRIMARY KEY (userId),
  INDEX FK_Users_1 (permissionId),
  INDEX FK_Users_2 (statusId),
  UNIQUE INDEX loginname (loginname),
  CONSTRAINT FK_Users_1 FOREIGN KEY (permissionId)
    REFERENCES permission(permissionId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_Users_2 FOREIGN KEY (statusId)
    REFERENCES userstatus(statusId) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 2
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci
COMMENT = 'InnoDB free: 727040 kB; (`permissionId`) REFER `webtech/Perm';

--
-- Definition for table wallet
--
CREATE TABLE IF NOT EXISTS wallet (
  walletId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  balance DOUBLE DEFAULT 0,
  lastUpdateDate DATETIME NOT NULL,
  userId INT(10) UNSIGNED NOT NULL,
  wallettype INT(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (walletId),
  INDEX FK_Wallet_1 (userId),
  CONSTRAINT FK_Wallet_1 FOREIGN KEY (userId)
    REFERENCES users(userId) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 2
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table investments
--
CREATE TABLE IF NOT EXISTS investments (
  invId INT(11) NOT NULL AUTO_INCREMENT,
  symbol VARCHAR(20) NOT NULL,
  amount DOUBLE NOT NULL,
  startDate DATE NOT NULL,
  value DOUBLE NOT NULL,
  walletId INT(10) UNSIGNED NOT NULL,
  isActive TINYINT(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (invId),
  INDEX FK_investments_wallet_walletId (walletId),
  CONSTRAINT FK_investments_wallet_walletId FOREIGN KEY (walletId)
    REFERENCES wallet(walletId) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table recurringtransaction
--
CREATE TABLE IF NOT EXISTS recurringtransaction (
  recTrans INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(100) DEFAULT NULL,
  wage DOUBLE UNSIGNED DEFAULT NULL,
  incomeDate DATE DEFAULT NULL,
  walletId INT(10) UNSIGNED DEFAULT NULL,
  isActive TINYINT(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (recTrans),
  INDEX FK_RecurringTransaction_1 (walletId),
  CONSTRAINT FK_RecurringTransaction_1 FOREIGN KEY (walletId)
    REFERENCES wallet(walletId) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table notifications
--
CREATE TABLE IF NOT EXISTS notifications (
  notificationId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  firstNoteDate DATE DEFAULT NULL,
  lastNoteDate DATE NOT NULL,
  walletId INT(10) UNSIGNED NOT NULL,
  recId INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (notificationId),
  INDEX FK_Notifications_1 (walletId),
  INDEX FK_notifications_2 (recId),
  CONSTRAINT FK_Notifications_1 FOREIGN KEY (walletId)
    REFERENCES wallet(walletId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_notifications_2 FOREIGN KEY (recId)
    REFERENCES recurringtransaction(recTrans) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci
COMMENT = 'InnoDB free: 988160 kB';

--
-- Definition for table transaction
--
CREATE TABLE IF NOT EXISTS transaction (
  transId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  amount DOUBLE DEFAULT 0,
  transDate DATE NOT NULL,
  isCommited TINYINT(1) NOT NULL DEFAULT 0,
  walletId INT(10) UNSIGNED NOT NULL,
  transTypeId INT(10) UNSIGNED NOT NULL,
  transCustomName VARCHAR(45) NOT NULL,
  recurrence INT(10) UNSIGNED NOT NULL DEFAULT 0,
  description VARCHAR(100) DEFAULT NULL,
  recId INT(10) UNSIGNED DEFAULT NULL,
  wage DOUBLE DEFAULT NULL,
  PRIMARY KEY (transId),
  INDEX FK_Transaction_1 (walletId),
  INDEX FK_Transaction_2 (transTypeId),
  INDEX FK_Transaction_3 (recurrence),
  INDEX FK_Transaction_4 (recId),
  CONSTRAINT FK_Transaction_1 FOREIGN KEY (walletId)
    REFERENCES wallet(walletId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_Transaction_2 FOREIGN KEY (transTypeId)
    REFERENCES transactiontype(typeId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_Transaction_3 FOREIGN KEY (recurrence)
    REFERENCES recurrencetype(recurTypeId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_Transaction_4 FOREIGN KEY (recId)
    REFERENCES recurringtransaction(recTrans) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci
COMMENT = 'InnoDB free: 733184 kB; (`type`) REFER `webtech/TransactionT';

--
-- Definition for table jobhours
--
CREATE TABLE IF NOT EXISTS jobhours (
  jobHoursId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  startHour DATETIME NOT NULL,
  endHour DATETIME NOT NULL,
  recId INT(10) UNSIGNED DEFAULT NULL,
  walletId INT(10) UNSIGNED DEFAULT NULL,
  description VARCHAR(200) DEFAULT NULL,
  isCalculated INT(11) NOT NULL DEFAULT 0,
  transId INT(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (jobHoursId),
  INDEX FK_JobHours_1 (recId),
  INDEX FK_JobHours_2 (walletId),
  INDEX FK_jobhours_transaction_transId (transId),
  CONSTRAINT FK_JobHours_1 FOREIGN KEY (recId)
    REFERENCES recurringtransaction(recTrans) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_JobHours_2 FOREIGN KEY (walletId)
    REFERENCES wallet(walletId) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_jobhours_transaction_transId FOREIGN KEY (transId)
    REFERENCES transaction(transId) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

DELIMITER $$

--
-- Definition for procedure balanceForecastReport
--
CREATE 
PROCEDURE balanceForecastReport(IN loginname VARCHAR(20))
BEGIN
  SET @uid = (SELECT userid FROM users u where u.loginname = loginname );
  SET @wid = (SELECT walletid FROM wallet w WHERE w.userId = @uid AND w.wallettype = 1);
IF @wid IS NULL THEN
  SELECT 'Incorrect details';
ELSE
  DROP TABLE IF EXISTS `webtechtest`.`result`,  `webtechtest`.`tempres` ;
  CREATE TEMPORARY TABLE `webtechtest`.`result` (transname VARCHAR(40), amount DOUBLE, month_name VARCHAR(30));
  CREATE TEMPORARY TABLE `webtechtest`.`tempres` (transname VARCHAR(40), amount DOUBLE, month_name VARCHAR(30));

  SET @yearStart = date_format(DATE(utc_timestamp() - interval 11 month), '%Y-%m-01');
  SET @monthStart = date_format(DATE(utc_timestamp()), '%Y-%m-01');
  SET @yearEnd = last_day(DATE(utc_timestamp()));

#------------- RUN yearly balance report -----------------#

  WHILE (date(@yearStart) <= @yearEnd) DO
    INSERT INTO `tempres` (transname, amount, month_name)
      SELECT 'One Time Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (1);

      INSERT INTO `tempres` (transname, amount, month_name)
      SELECT 'Recurring Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (2);

      INSERT INTO `tempres` (transname, amount, month_name)
      SELECT 'Jobs', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (3);

      INSERT INTO `tempres` (transname, amount, month_name)
      SELECT 'One Time Payout', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (5);
      
      INSERT INTO `tempres` (transname, amount, month_name)
      SELECT 'Recurring Payout', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (6,7);     
      
   SET @yearStart = @yearStart + interval 1 month;
  END WHILE;

#--------------------------------------------------------#
    SET @avgOTinc= (SELECT avg(amount) FROM `tempres` where transname = 'One Time Income');
    SET @avgREinc= (SELECT avg(amount) FROM `tempres` where transname = 'Recurring Income');
    SET @avgJob= (SELECT avg(amount) FROM `tempres` where transname = 'Jobs');
    SET @avgOTpay= (SELECT avg(amount) FROM `tempres` where transname = 'One Time Payout');
    SET @avgREpay= (SELECT avg(amount) FROM `tempres` where transname = 'Recurring Payout');

  #--------------- This month ----------------#
    INSERT INTO result (transname, amount, month_name)
      SELECT 'One Time Income', sum(t.amount), monthname(@monthStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @monthStart AND @monthStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (1);
      
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Income', sum(t.amount), monthname(@monthStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @monthStart AND @monthStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (2);

      INSERT INTO result (transname, amount, month_name)
      SELECT 'Jobs', sum(t.amount), monthname(@monthStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @monthStart AND @monthStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (3);

      INSERT INTO result (transname, amount, month_name)
      SELECT 'One Time Payout', sum(t.amount), monthname(@monthStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @monthStart AND @monthStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (5);
      
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Payout', sum(t.amount), monthname(@monthStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @monthStart AND @monthStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (6,7);

#---------------------- Forecast ----------------#
 SET @yearStart = date_format(DATE(utc_timestamp() - interval 11 month), '%Y-%m-01');
 SET @yearEnd = last_day(DATE(utc_timestamp())- interval 1 month);
 
  WHILE (date(@yearStart) <= @yearEnd) DO
    IF (SELECT count(*) FROM transaction t WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (1) ) > 0 THEN 
    INSERT INTO result (transname, amount, month_name)
      SELECT 'One Time Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (1);
    ELSE
         INSERT INTO result (transname, amount, month_name)
        SELECT 'One Time Income', @avgOTinc, monthname(@yearStart);
     END IF;

    IF (SELECT count(*) FROM  transaction t WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (2))  > 0 THEN 
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (2);
       
       ELSE
          INSERT INTO result (transname, amount, month_name)
          SELECT 'Recurring Income', @avgREinc, monthname(@yearStart);
       END IF;

    IF (SELECT count(*) FROM  transaction t WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (3) ) > 0 THEN 
        INSERT INTO result (transname, amount, month_name)
        SELECT 'Jobs', sum(t.amount), monthname(@yearStart)
        FROM transaction t
        WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (3);
  
    ELSE 
        INSERT INTO result (transname, amount, month_name)
        SELECT 'Jobs', @avgJob, monthname(@yearStart);
    END IF;
 
   IF (SELECT count(*) FROM  transaction t WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (5) ) > 0 THEN 
        INSERT INTO result (transname, amount, month_name)
        SELECT 'One Time Payout', sum(t.amount), monthname(@yearStart)
        FROM transaction t
        WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (5);
  
    ELSE
           INSERT INTO result (transname, amount, month_name)
           SELECT 'One Time Payout', @avgOTpay, monthname(@yearStart);
    END IF;

   IF (SELECT count(*) FROM  transaction t WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
        AND t.transTypeId IN (6,7) ) > 0 THEN 
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Payout', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart AND @yearStart + interval 1 month -interval 1 day 
      AND t.transTypeId IN (6,7);
     
   ELSE
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Payout', @avgREpay, monthname(@yearStart);
   END IF;
   
   SET @yearStart = @yearStart + interval 1 month;
  END WHILE;
  
  SElECT * FROM result;
END IF;

END
$$

--
-- Definition for procedure balanceYearlyReport
--
CREATE 
PROCEDURE balanceYearlyReport(IN loginname VARCHAR(20))
BEGIN
  SET @uid = (SELECT userid FROM users u where u.loginname = loginname );
  SET @wid = (SELECT walletid FROM wallet w WHERE w.userId = @uid AND w.wallettype = 1);
IF @wid IS NULL THEN
  SELECT 'Incorrect details';
ELSE
  DROP TABLE IF EXISTS `webtechtest`.`result` ;
  CREATE TEMPORARY TABLE `webtechtest`.`result` (transname VARCHAR(40), amount DOUBLE, month_name VARCHAR(30));

  SET @yearStart = date_format(DATE(utc_timestamp() - interval 11 month), '%Y-%m-01');
  SET @yearEnd = last_day(DATE(utc_timestamp()));

  WHILE (date(@yearStart) <= @yearEnd) DO
    INSERT INTO result (transname, amount, month_name)
      SELECT 'One Time Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart 
        AND @yearStart + interval 1 month -interval 1 day AND t.transTypeId IN (1);
      
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Income', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart 
        AND @yearStart + interval 1 month -interval 1 day AND t.transTypeId IN (2);

      INSERT INTO result (transname, amount, month_name)
      SELECT 'Jobs', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart 
        AND @yearStart + interval 1 month -interval 1 day AND t.transTypeId IN (3);

      INSERT INTO result (transname, amount, month_name)
      SELECT 'One Time Payout', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart 
        AND @yearStart + interval 1 month -interval 1 day AND t.transTypeId IN (5);
      
      INSERT INTO result (transname, amount, month_name)
      SELECT 'Recurring Payout', sum(t.amount), monthname(@yearStart)
      FROM transaction t
      WHERE t.walletId = @wid AND t.transDate BETWEEN @yearStart 
        AND @yearStart + interval 1 month -interval 1 day AND t.transTypeId IN (6,7);
      

   SET @yearStart = @yearStart + interval 1 month;
  END WHILE;
  SElECT * FROM result;
END IF;

END
$$

--
-- Definition for procedure clearAndFillDb
--
CREATE 
PROCEDURE clearAndFillDb(IN loginname varchar(20), IN toClear INT)
BEGIN
#-------------------- choose loginname -----------------------------------------------------#
SET @loginname = loginname;
#____________________________________________________________________________________________#
  SET @uid = (SELECT userid FROM users u where u.loginname = loginname );
  SET @wid = (SELECT walletid FROM wallet w WHERE w.userId = @uid AND w.wallettype = 1);

# ------------------------------ CLEAR!!! --------------------------------------------------#
IF (toClear = 1) THEN
  truncate notifications;
  truncate jobhours;
  
  truncate transaction;
  truncate recurringtransaction;
END IF;

# --------------------------------- Fill  --------------------------------------------------#


#Insert one time incomes
SET @count = 7;
SET @tempdate = utc_timestamp() - interval 1 month;
WHILE (@count > 0 ) DO
  call insertTransaction(@count*2, @loginname, @tempDate, 'one time income - auto', 9,1,null,'auto - one time income description');
  set @tempDate = @tempdate + interval @count day;
  SET @count = @count - 1;
END WHILE;
#Insert one time payouts
SET @count = 7;
SET @tempdate = utc_timestamp() - interval 1 month;
WHILE (@count > 0 ) DO
  call insertTransaction(-(@count*2), @loginname, @tempDate, 'one time payout - auto', 9,5,null,'auto - one time payout description');
  set @tempDate = @tempdate + interval @count day;
  SET @count = @count - 1;
END WHILE;
#Insert recurring incomes
SET @count = 4;
SET @tempdate = utc_timestamp() - interval 2 month;
WHILE (@count > 0 ) DO
  call insertTransaction(@count*20, @loginname, @tempDate, 'recurring income - auto', 1,2,null,'auto - recurring income description');
  set @tempDate = @tempdate + interval @count day;
  SET @count = @count - 1;
END WHILE;
#Insert recurring incomes
SET @count = 3;
SET @tempdate = utc_timestamp() - interval 5 month;
WHILE (@count > 0 ) DO
  call insertTransaction(-(@count*20), @loginname, @tempDate, 'recurring payouts - auto', 4,6,null,'auto - recurring payouts description');
  set @tempDate = @tempdate + interval @count day;
  SET @count = @count - 1;
END WHILE;
#Insert jobs
SET @count = 3;
SET @tempdate = utc_timestamp() - interval 5 month;
WHILE (@count > 0 ) DO
  call insertJob(@loginname, concat('Job name', @count), concat('Desc name',@count), 25.7, utc_timestamp() + interval @count day);
  set @tempDate = @tempdate + interval @count day;
  SET @count = @count - 1;
END WHILE;

update wallet set balance = 1000 where walletId = @wid and wallettype = 1;

END
$$

--
-- Definition for procedure commitDailyNotifications
--
CREATE 
PROCEDURE commitDailyNotifications()
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`temp`, `webtechtest`.`result`;
CREATE TEMPORARY TABLE `webtechtest`.`temp`(notId INT(10), recId INT (10), recName VARCHAR(45), email VARCHAR(45), notType INT);
CREATE TEMPORARY TABLE `webtechtest`.`result`(notId INT(10), recId INT (10), recName VARCHAR(45), email VARCHAR(45), notType INT);


#---------select all emails to send notifications to-----------------------------#
INSERT INTO temp
SELECT n.notificationId, rt.recTrans, rt.name, u.email, 1
 FROM notifications n, recurringtransaction rt, users u, wallet w 
 WHERE n.recId = rt.recTrans AND rt.walletId= w.walletId AND 
 u.userId= w.userId AND
 n.firstNoteDate = date(utc_timestamp());

INSERT INTO temp
SELECT n.notificationId, rt.recTrans, rt.name, u.email, 2
 FROM notifications n, recurringtransaction rt, users u, wallet w 
 WHERE n.recId = rt.recTrans AND rt.walletId= w.walletId AND 
 u.userId= w.userId AND
 n.lastNoteDate = date(utc_timestamp());

 #---------calculate next notification date          -----------------------------#
SET @rows = (SELECT count(*) FROM temp);
WHILE (@rows > 0) DO 
  SELECT t.recId, t.notType INTO @rec, @notType FROM temp t limit 1;
  SELECT t.recurrence INTO @recType FROM transaction t, notifications n WHERE n.recId = @rec AND 
  t.recId = @rec;
  SET @nextDate = getFutureTrans(date(utc_timestamp()), @recType);
  IF (@notType = 1) THEN
    UPDATE notifications SET firstNoteDate = @nextDate WHERE recId = @rec;
  ELSE
    UPDATE notifications SET lastNoteDate = @nextDate WHERE recId = @rec;
  END IF;
 
 INSERT INTO result
    SELECT * FROM temp LIMIT 1;
  DELETE FROM temp LIMIT 1;
  SET @rows = (SELECT count(*) FROM temp);
END WHILE;
#---------return list of emails to send them notifications-----------------------#
  #INSERT INTO commitdailyjoblog (`runDate`, `isSuccessful`, `jobName`) VALUES (utc_timestamp(), 1, 'commitDailyNotifications');  
SELECT * FROM result;
END
$$

--
-- Definition for procedure commitDailyTrans
--
CREATE 
PROCEDURE commitDailyTrans()
BEGIN

IF (SELECT count(*) FROM transaction t WHERE t.isCommited = 0 and t.transDate <= date(utc_timestamp()) > 0) THEN
  # ---------------------- All future transactions except from Recurring generated payout! ------------#
  SET @rows = (SELECT count(*) FROM transaction t WHERE t.isCommited = 0 and t.transDate <= date(utc_timestamp()) and t.transTypeId <> 7);
  IF ( @rows > 0) THEN 
    DROP TABLE IF EXISTS `webtechtest`.`temp`;
    CREATE TEMPORARY TABLE `webtechtest`.`temp` (`rowid` INT,`transID` INT, `walletid` INT, `amount` DOUBLE, `recurrence` INT, `recid` INT, `transTypeId` INT(10),`transname` VARCHAR(45),  `description` VARCHAR(100));
  
    INSERT INTO `temp` (`rowid`,`transID`, `walletid`, `amount`, `recurrence`, `recid`,`transTypeId`,`transname`, `description`)
    SELECT @rownum:=@rownum+1 `rowid`, t.transId, t.walletId, t.amount, t.recurrence, t.recId, t.transTypeId, t.transCustomName, t.description
      FROM transaction t, (SELECT @rownum:=0) r 
      WHERE t.isCommited = 0 and t.transDate <= date(utc_timestamp()) and t.transTypeId <> 7;
  
    SET @i=1; 
    SET @trans = 0; SET @wid = 0; SET @amount = 0.0; SET @recur = 0; SET @recid = 0; SET @transTypeId = 0; SET @transCustomName = null; SET @description = null;
  
    WHILE (@i <= @rows) DO
      SELECT `transID`, `walletid`, `amount`, `recurrence`, `recid`,`transTypeId`,`transname`, `description` 
      INTO @trans, @wid, @amount, @recur, @recid, @transTypeId, @transCustomName, @description
      FROM  `temp`  WHERE rowid = @i;
  
      UPDATE `wallet` SET balance = balance + @amount, lastUpdateDate = utc_timestamp() where walletId = @wid;
      UPDATE `transaction` SET isCommited = 1 where transId = @trans;
     
     #Calculate the next transaction, if recurring
      IF (@recur >= 1 and @recur < 11 ) then
        SET @futuredate = getFutureTrans(date(utc_timestamp()), @recur);
        #Create future uncommitted transaction
        INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence`, `description` )
  						VALUES ( @amount,  @futuredate, 0, @wid, @transtypeid, @transcustomname, @recur, @description);
      END IF;
      SET @i = @i +1;
    END WHILE;
  END IF;

  # ---------------------- ONLY Recurring generated payout future transactions ! ------------#
  SET @rows = (SELECT count(*) FROM transaction t WHERE t.isCommited = 0 and t.transDate <= date(utc_timestamp()) and t.transTypeId = 7);
  IF ( @rows > 0) THEN 
    DROP TABLE IF EXISTS `webtechtest`.`temp`;
    CREATE TEMPORARY TABLE `webtechtest`.`temp` (`rowid` INT,`transID` INT, `walletid` INT, `amount` DOUBLE, `recurrence` INT, `recid` INT, `transTypeId` INT(10),`transname` VARCHAR(45),  `description` VARCHAR(100));
  
    INSERT INTO `temp` (`rowid`,`transID`, `walletid`, `amount`, `recurrence`, `recid`,`transTypeId`,`transname`, `description`)
    SELECT @rownum:=@rownum+1 `rowid`, t.transId, t.walletId, t.amount, t.recurrence, t.recId, t.transTypeId, t.transCustomName, t.description
      FROM transaction t, (SELECT @rownum:=0) r 
      WHERE t.isCommited = 0 and t.transDate <= date(utc_timestamp()) and t.transTypeId = 7;
  
    SET @i=1; 
    SET @trans = 0; SET @wid = 0; SET @amount = 0.0; SET @recur = 0; SET @recid = 0; SET @transTypeId = 0; SET @transCustomName = null; SET @description = null;
  
    WHILE (@i <= @rows) DO
      SELECT `transID`, `walletid`, `amount`, `recurrence`, `recid`,`transTypeId`,`transname`, `description` 
      INTO @trans, @wid, @amount, @recur, @recid, @transTypeId, @transCustomName, @description
      FROM  `temp`  WHERE rowid = @i;
    
      IF @amount IS NOT NULL THEN
        UPDATE `wallet` SET balance = balance + @amount, lastUpdateDate = utc_timestamp() where walletId = @wid;
        UPDATE `transaction` SET isCommited = 1 where transId = @trans;
      END IF;
     #Calculate the next transaction, if recurring - recurring generated payouts cannot be daily
      IF (@recur >= 1 and @recur < 9 ) then
      #Create future uncommitted transaction
        INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence`, `description` )
  						VALUES ( @amount,  @futuredate, 0, @wid, @transtypeid, @transcustomname, @recur, @description);
        SET @futuredate = getFutureTrans(date(utc_timestamp()), @recur);
        IF ( SELECT n.firstNoteDate FROM notifications n WHERE n.recId = @recid IS NOT NULL ) THEN
          SET @firstNote = (SELECT n.firstNoteDate FROM notifications n WHERE n.recId = @recid);
          SET @firstNote = getFutureTrans(@firstNote, @recur);
          UPDATE notifications SET firstNoteDate = @firstNote, lastNoteDate = @futuredate - interval 3 day
          WHERE recId = @recid;
        ELSEIF ( SELECT n.lastNoteDate FROM notifications n WHERE n.recId = @recid IS NOT NULL ) THEN
          UPDATE notifications SET lastNoteDate = @futuredate - interval 3 day WHERE recId = @recid;
  
        END IF;
       
      END IF;
      SET @i = @i +1;
    END WHILE;
  END IF;

  INSERT INTO commitdailyjoblog (`runDate`, `isSuccessful`, `jobName`) VALUES (utc_timestamp(), 1, 'commitDailyTrans');  
ELSE

  INSERT INTO commitdailyjoblog (`runDate`, `isSuccessful`, `jobName`) VALUES (utc_timestamp(), 1, 'commitDailyTrans');
  END IF;

END
$$

--
-- Definition for procedure commitJobHours
--
CREATE 
PROCEDURE commitJobHours()
BEGIN

DROP TABLE IF EXISTS `webtechtest`.`tempRec`, `webtechtest`.`tempJob`;
CREATE TEMPORARY TABLE `webtechtest`.`tempRec` (`recid` INT, `incomeDate` DATE, `wage` DOUBLE, jobName VARCHAR(45), description VARCHAR(100), walletId INT(10));
CREATE TEMPORARY TABLE `webtechtest`.`tempJob`(`jobhoursId` INT, startHour DATETIME, endHour DATETIME);

INSERT INTO `tempRec`(`recid`, `incomeDate`, `wage`, `jobName`, `description`, `walletId`)
SELECT jh.recId, rt.incomeDate, rt.wage, rt.name, rt.description, rt.walletId FROM recurringtransaction rt, jobhours jh 
    WHERE jh.recId = rt.recTrans and rt.incomeDate <= date(utc_timestamp()) and jh.isCalculated = 0 and rt.isActive = 1 GROUP BY jh.recId;

SET @rows = row_count();
# For every recurring income that has un committed jobhours
  WHILE (@rows > 0) DO

      SELECT tr.recid , tr.incomeDate, tr.wage, tr.jobName, tr.description, tr.walletId INTO @rec, @incDate, @wage, @name, @desc, @wid
        FROM `tempRec` tr LIMIT 1;
  
      INSERT INTO `tempJob`(`jobhoursId`, startHour, endHour)
        SELECT jh.jobHoursId, jh.startHour, jh.endHour  FROM  jobhours jh
        WHERE jh.recId = @rec AND jh.isCalculated = 0 AND jh.startHour < date(utc_timestamp()) ;
  
      SET @JHrows = row_count();
      SET @amount = 0;
      # for every JH instance
      WHILE (@JHrows > 0 ) DO
          SELECT jh.jobHoursId, jh.startHour, jh.endHour INTO @jhId, @start, @end FROM `tempJob` jh LIMIT 1;
          SET @amount = @amount + calcSalaryHourWage(@start, @end, @wage);
          UPDATE jobhours SET isCalculated = 1 WHERE jobHoursId = @jhid;
    
          DELETE FROM `tempJob` LIMIT 1;
          SET @JHrows = (SELECT count(*) FROM `tempJob`);
  
      END WHILE;
  
      SET @trans = (SELECT t.transId FROM transaction t WHERE recId = @rec and isCommited = 0);
      
      UPDATE `transaction` SET amount = @amount, isCommited = 1 WHERE transId = @trans;
      UPDATE wallet SET balance = balance + @amount, lastUpdateDate = utc_timestamp() WHERE walletId = @wid;
      UPDATE jobhours SET transId = @trans WHERE recId = @rec and transId IS NULL AND startHour < date(utc_timestamp());
      IF @incDate = LAST_DAY(@incDate) THEN
	  			SET @incDate = LAST_DAY(@incDate + INTERVAL 1 month);
      ELSE
          SET @incDate = @incDate + INTERVAL 1 month;
      END IF;
      
      UPDATE recurringtransaction SET incomeDate = @incDate where recTrans = @rec;
      INSERT INTO `webtechtest`.`transaction` (amount,transDate,isCommited,walletId,transTypeId,transCustomName,recurrence,description,recId,wage)
      VALUES (null,@incDate, 0, @wid, 3, @name, 4, @desc, @rec, @wage);
  
  
       DELETE FROM `tempRec` where recid = @rec;
       SET @rows = (SELECT count(*) FROM `tempRec`);
  END WHILE;
  #INSERT INTO commitdailyjoblog (`runDate`, `isSuccessful`, `jobName`) VALUES (utc_timestamp(), 1, 'commitJobHours');  

END
$$

--
-- Definition for procedure createInvestment
--
CREATE 
PROCEDURE createInvestment(IN loginname VARCHAR(20),IN symbol VARCHAR(20),IN amount DOUBLE, IN startDate DATE, IN val DOUBLE )
BEGIN

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 2);

IF @uid IS NULL THEN
  SELECT 'loginname is incorrect';

ELSEIF @wid IS NULL THEN
    INSERT INTO wallet (`balance`,`lastupdatedate`,`userid`, `wallettype`)
          VALUES (0, utc_timestamp(),@uid, 2);
    SET @wid = last_insert_id();
END IF;
IF @uid IS NOT NULL AND @wid IS NOT NULL THEN
  INSERT INTO investments(`symbol`, `amount`, `startDate`, `value`, `walletId`)
    VALUES (symbol, amount, startDate, val, @wid);
    SET @iid = last_insert_id();
    SELECT @iid;
END IF;



END
$$

--
-- Definition for procedure deleteInvestment
--
CREATE 
PROCEDURE deleteInvestment(IN invId INT(10))
BEGIN

IF (invId is null OR (SELECT count(*) FROM investments i WHERE i.invId = invId) = 0 ) THEN
  SELECT 'invId is incorrect';
ELSE
  UPDATE investments i SET i.isActive = 0 WHERE i.invId = invId;
  SELECT 0;
END IF;
END
$$

--
-- Definition for procedure deleteTransaction
--
CREATE 
PROCEDURE deleteTransaction(loginname VARCHAR(20), id INT, transtype INT, deleteType INT, onDate DATE)
BEGIN
SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletId from wallet where userId = @uid and wallettype = 1);

IF (@wid > 0 AND id > 0 AND transtype IN (1,2,3) AND deleteType IN (1,2,3) AND onDate IS NOT NULL) THEN
   #1=recId, 2=transId, 3=jobHoursId
  CASE transtype
    #Delete recurringTransaction --------------------------------------------
    WHEN 1 THEN 
      IF(SELECT count(*) FROM recurringtransaction WHERE recTrans = id > 0) THEN
        CASE deleteType
        #1=on this date(date = onDate), 2 =  future, 3= all
          WHEN 1 THEN
            UPDATE recurringtransaction SET isActive = 0 WHERE recTrans = id;
            DELETE from notifications where recId = id;
            SELECT 0;
          WHEN 2 THEN
            DROP TABLE IF EXISTS `webtechtest`.`temp`;
            CREATE TEMPORARY TABLE temp (transid INT(10), amount DOUBLE, isCommited INT);

            INSERT INTO temp
            SELECT t.transid, t.amount, t.isCommited FROM transaction t, recurringtransaction rt 
            WHERE t.recId = rt.recTrans and t.recId = id and t.transDate >= onDate;

            SET @rows = row_count();
            WHILE @rows > 0 DO
              SELECT `transID`,`amount`,`isCommited` 
              INTO @trans, @amount, @isCommited
              FROM  `temp`  LIMIT 1;
              
              IF @isCommited = 1 THEN
                UPDATE wallet SET balance = balance + @amount, lastUpdateDate = utc_timestamp() WHERE walletId = @wid;
              END IF;
              
              DELETE FROM transaction WHERE transId = @trans;
              DELETE from temp where transid = @trans;
              SET @rows = (SELECT count(*) FROM temp);
            END WHILE;
            UPDATE recurringtransaction SET isActive = 0 WHERE recTrans = id;
            SELECT 0;

          WHEN 3 THEN
            IF ((SELECT rt.incomeDate FROM recurringtransaction rt WHERE rt.recTrans = id) IS NULL 
              AND (SELECT rt.wage FROM recurringtransaction rt WHERE rt.recTrans = id) IS NULL)  THEN

              DROP TABLE IF EXISTS `webtechtest`.`temp`;
              CREATE TEMPORARY TABLE temp (transid INT(10), amount DOUBLE, isCommited INT);
  
              INSERT INTO temp
              SELECT t.transid, t.amount, t.isCommited FROM transaction t, recurringtransaction rt 
              WHERE t.recId = rt.recTrans and t.recId = id;
  
              SET @rows = row_count();
              WHILE @rows > 0 DO
                SELECT `transID`,`amount`,`isCommited` 
                INTO @trans, @amount, @isCommited
                FROM  `temp`  LIMIT 1;
                
                IF @isCommited = 1 THEN
                    UPDATE wallet SET balance = balance - @amount, lastUpdateDate = utc_timestamp() WHERE walletId = @wid;
                END IF;
                
                DELETE FROM transaction WHERE transId = @trans;
                DELETE FROM temp where transId = @trans;
                SET @rows = (SELECT count(*) FROM temp);
              END WHILE;
              DELETE from notifications where recId = id;
              UPDATE recurringtransaction SET isActive = 0 WHERE recTrans = id;
              SELECT 0;

          ELSE #----------------- If we delete the whole job lists -----------------------#
           DROP TABLE IF EXISTS `webtechtest`.`temp`;
           CREATE TEMPORARY TABLE `temp` (transid INT(10), amount DOUBLE, wage DOUBLE ,isCommited INT);
            
           INSERT INTO temp 
           SELECT t.transId, t.amount,t.wage,t.isCommited FROM `transaction` t WHERE t.recId = id;
           SET @rows = row_count();

           DELETE FROM jobhours where recId = id;
          
           WHILE @rows > 0 DO
              SELECT t.transId, t.amount,t.wage,t.isCommited
              INTO @trans, @amount, @wage, @isCommited
              FROM `temp` t LIMIT 1;
              
              IF (@isCommited = 1) THEN
                UPDATE wallet SET balance = balance - @amount, lastUpdateDate = utc_timestamp() WHERE walletId = @wid;
                DELETE FROM transaction WHERE transid = @trans;
              END IF;  
              DELETE FROM temp WHERE transid = @trans;
              SET @rows = @rows - 1;
            END WHILE;
            SELECT 0;
          END IF;
          UPDATE recurringtransaction SET isActive = 0 WHERE recTrans = id;
          END CASE;
      ELSE
          SELECT 'invalid id!';
      END IF;

    #Delete single transaction --------------------------------------------------------------------
    WHEN 2 THEN 
       IF((SELECT count(*) FROM transaction WHERE transId = id and walletId = @wid and transDate = onDate ) > 0) THEN
          IF (SELECT isCommited FROM transaction WHERE transId = id and walletId = @wid and transDate = onDate) = 1 THEN
            SET @amount = (SELECT amount FROM transaction WHERE transId = id and walletId = @wid and transDate = onDate);
            UPDATE wallet SET balance = balance - @amount;
            DELETE FROM transaction WHERE transId = id;
            SELECT 0;
          ELSE
            DELETE FROM transaction WHERE transId = id;
            SELECT 0;
          END IF;
       END IF;

    #Delete JobHour ------------------------------------------------------------------------------
    WHEN 3 THEN 
     IF((SELECT count(*) FROM jobhours WHERE jobHoursId = id) > 0) THEN
        SET @rec = (select recId from jobhours where jobHoursId = id);
        SET @transId = (select jh.transId from jobhours jh where jh.jobHoursId = id);
        CASE deleteType
        #1=on this date(date = onDate), 2 =  future, 3= all
          WHEN 1 THEN
        
            IF ((SELECT isCalculated FROM jobhours WHERE jobHoursId = id ) = 0) THEN
              DELETE FROM jobhours WHERE jobHoursId = id;
            ELSE
               SET @wage = (select t.wage from transaction t where transId = @transId);
               SELECT jh.startHour, jh.endHour INTO @start, @end FROM jobhours jh WHERE jh.jobHoursId = id;
               update wallet set balance = balance - calcSalaryHourWage(@start, @end, @wage), lastUpdateDate = utc_timestamp() where walletId = @wid;
               update transaction set amount = amount - calcSalaryHourWage(@start, @end, @wage) where transId= @transId;
               DELETE FROM jobhours WHERE jobHoursId = id;
            END IF;

--           WHEN 2 THEN
--           
--             DROP TABLE IF EXISTS `webtechtest`.`temp`, `webtechtest`.`temptrans`;
--             CREATE TEMPORARY TABLE `temp` (transid INT(10), amount DOUBLE, isCommited INT);
--             CREATE TEMPORARY TABLE `temptrans` (transid INT(10));
--             
               # --- listing all transactions that were generated for a month of Jobhours#
--             INSERT INTO `temptrans`
--             SELECT jh.transid FROM jobhours jh, transaction t 
--             WHERE jh.transId = t.transId AND jh.recId = @rec AND jh.startHour >=onDate
--             GROUP BY t.transId;
--             
--             SET @transrows = row_count();
--             # --- listing all future transactions details#
--             INSERT INTO temp
--             SELECT jh.transid, t.amount, t.isCommited FROM jobhours jh, transaction t 
--             WHERE jh.transId = t.transId AND jh.recId = @rec AND jh.startHour >=onDate;
-- 
--             SET @rows = row_count();
--             WHILE @rows > 0 DO
--               SELECT `transId`, `amount`, `isCommited` 
--               INTO @transId, @amount, @isCommited
--               FROM  `temp`  LIMIT 1;
--               
--               IF (@iscommited = 1)
--                 UPDATE wallet SET balance = balance - @amount, lastUpdateDate = utc_timestamp() WHERE walletId = @wid;
--                 DELETE FROM temp WHERE transId = @transId;
--                            
--                 SET @rows = (SELECT count(*) FROM temp);
--               END IF;
--             END WHILE;
-- 
--             DELETE FROM jobhours WHERE recId = @rec AND jh.startHour >= onDate;
--   

       
         END CASE;
       END IF;
  END CASE;

ELSE
  SELECT -1;

END IF;
END
$$

--
-- Definition for procedure deleteUser
--
CREATE 
PROCEDURE deleteUser(IN loginname VARCHAR(20))
BEGIN
  IF (SELECT count(*) FROM users u WHERE u.loginname= loginname) > 0 THEN
    UPDATE users u SET u.statusId = 3, u.statusChangeDate = utc_timestamp, u.statusChangeComment = 'Account was deleted' 
      WHERE u.loginname = loginname;
    SELECT 0;
  ELSE
    SELECT -1;
  END IF;


END
$$

--
-- Definition for procedure doLogin
--
CREATE 
PROCEDURE doLogin(IN login VARCHAR(20), IN pass VARCHAR(45))
BEGIN

IF ((SELECT count(*) FROM webtechtest.users u
		WHERE u.loginname = login and u.pincode = pass and u.statusId = 1) > 0) THEN
      SELECT firstname, lastName, dateOfBirth, statusId, permissionId, email
    		FROM webtechtest.users u
    		WHERE u.loginname = login and u.pincode = pass and u.statusId = 1;
ELSEIF (SELECT count(*) FROM webtechtest.users u
  	  	WHERE u.loginname = login and u.pincode = pass and u.statusId = 2) > 0 THEN
        SELECT 'Locked account';
ELSEIF (SELECT count(*) FROM webtechtest.users u
  	  	WHERE u.loginname = login and u.pincode = pass and u.statusId NOT IN (1,2,3) ) = 0 THEN
        SELECT 'Incorrect account details';
ELSE
      SELECT 'Account Deleted';
END IF;

END
$$

--
-- Definition for procedure editJobDetails
--
CREATE 
PROCEDURE editJobDetails(IN jobid INT(10), IN jobName VARCHAR(45), IN description VARCHAR(100), IN wage DOUBLE, IN incomeDate DATE)
BEGIN
IF (jobid > 0 and (SELECT count(*) from recurringtransaction rt where rt.recTrans = jobid) > 0) THEN
    IF jobName is not null THEN
      UPDATE recurringtransaction SET `name` = jobName where recTrans = jobid;
    END IF;
    IF description is not null THEN
      UPDATE recurringtransaction SET `description` = description where recTrans = jobid;
    END IF;
    IF wage is not null THEN
      UPDATE recurringtransaction SET `wage`= wage where recTrans = jobid;
    END IF;
    IF incomeDate is not null THEN
      IF incomeDate >= date(utc_timestamp()) THEN
        
        UPDATE recurringtransaction SET `incomeDate` = incomeDate where recTrans = jobid;
        SELECT rt.incomeDate from recurringtransaction  rt where rt.recTrans = jobid;
      END IF;
    END IF;
END IF;

END
$$

--
-- Definition for procedure editOneTimeTransDetails
--
CREATE 
PROCEDURE editOneTimeTransDetails(IN transnum INT(10), IN transName VARCHAR(45), IN description VARCHAR(100), IN amount DOUBLE)
BEGIN
IF (transnum > 0 and (SELECT count(*) from `transaction` t where t.transId = transnum) > 0) THEN

    SET @transdate = (select t.transDate from `transaction` t where t.transId = transnum);
    SET @wid = (select t.walletId from `transaction` t where t.transId = transnum);

    IF transName is not null THEN
      UPDATE `transaction` SET `transcustomname` = transName where transId = transnum;
    END IF;

    IF description is not null THEN
      UPDATE `transaction` SET `description` = description where transId = transnum;
    END IF;

    IF amount is not null THEN
      IF @transdate <= DATE(utc_timestamp()) THEN
        SET @prevamount = (SELECT t.amount FROM `transaction` t where transId = transnum);
        UPDATE `transaction` SET `amount`= amount where transId = transnum;
        UPDATE wallet SET balance = balance-@prevamount+amount, lastUpdateDate = utc_timestamp() where walletId = @wid;
      END IF;
    END IF;

END IF;

END
$$

--
-- Definition for procedure editRecurringTransDetails
--
CREATE 
PROCEDURE editRecurringTransDetails(IN recTransId INT(10), IN transName VARCHAR(45), IN description VARCHAR(100), IN recType INT(10), IN newamount DOUBLE, IN changePeriod INT(10), IN onDate DATE, IN toEditNote TINYINT)
BEGIN
IF (recTransId > 0 and (SELECT count(*) from recurringtransaction rt, `transaction` t where rt.recTrans = recTransId and t.recid= recTransId and t.transDate = onDate ) > 0) THEN
    SET @wid = (SELECT rt.walletId FROM recurringtransaction rt WHERE rt.recTrans = recTransId);
    
    IF transName IS NOT NULL THEN
      IF (changePeriod = 1 AND onDate is not null AND
       (select count(*) from `transaction` t where t.recId = recTransId and t.transDate = onDate) = 1) THEN
          UPDATE `transaction` SET `transCustomName` = transName where recId = recTransId and transDate = onDate;
      ELSE   
        UPDATE recurringtransaction SET `name` = transName where recTrans = recTransId;
      END IF;
    END IF;

    IF (toEditNote = 1) THEN
        IF ((select t.transTypeId from transaction t where t.recId = recTransId limit 1) = 6) THEN
          SET @noteDate = (select max(t.transdate) from transaction t where t.recId = recTransId and t.isCommited = 0 limit 1);
          SELECT rt.walletId INTO @wid FROM recurringtransaction rt WHERE rt.recTrans = recTransId;
  				INSERT INTO `webtechtest`.`notifications` (`firstnotedate`,`lastnotedate`,`walletid`,`recid`)
  					VALUES(null, @noteDate , @wid, recTransId);
        END IF;
    ELSEIF toEditNote = 0 THEN
        DELETE FROM notifications where recId = recTransId;
    END IF;

    IF description is not null THEN
      IF (changePeriod = 1 AND onDate is not null AND
         (select count(*) from `transaction` t where t.recId = recTransId and t.transDate = onDate) = 1) THEN
            UPDATE `transaction` SET `description` = description where recId = recTransId and transDate = onDate;
      ELSE  
        UPDATE recurringtransaction SET `description` = description where recTrans = recTransId;
      END IF;
    END IF;

    IF recType is not null THEN
      IF (SELECT count(*) FROM `transaction` t WHERE t.recId = recTransId and t.transDate > DATE(utc_timestamp())) > 0 THEN
        SET @futureTrans = (SELECT t.transid FROM `transaction` t WHERE t.recId = recTransId and t.transDate > DATE(utc_timestamp()));
        UPDATE `transaction` SET recurrence = recType WHERE transId = @futureTrans;
      ELSE
        SET @futureTrans = (SELECT min(t.transid) FROM `transaction` t WHERE t.recId = recTransId and t.transDate > DATE(utc_timestamp()));
        UPDATE `transaction` SET recurrence = recType WHERE transId = @futureTrans;
      END IF;
    END IF;
    
    IF (newamount IS NOT NULL AND changePeriod IS NOT NULL) THEN
      case changePeriod 
          WHEN 1 THEN
            SET @trans = 0; 
            SET @oldamount = 0; 
            SET @commitstatus = 0; 
            SET @transtype = 0;
            SELECT transid, amount, iscommited, transTypeId INTO @trans, @oldamount, @commitstatus, @transtype FROM `transaction` t WHERE t.recId = recTransId AND t.transDate = onDate ;
            
            IF (@commitstatus = 1) THEN
                IF @transtype in (2,3) and newamount > @oldamount THEN
                  UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (2,3) and newamount < @oldamount THEN
                  UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (6,7) and newamount > @oldamount THEN
                  UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (6,7) and newamount < @oldamount THEN
                  UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
             END IF;
  
             UPDATE transaction SET `amount` = newamount WHERE transId = @trans;
          
          WHEN 2 THEN
          SET @transtype = 0;
          SELECT transTypeId INTO @transtype FROM `transaction` t WHERE t.recId = recTransId AND t.transDate = onDate ;

          DROP TABLE IF EXISTS `webtechtest`.`temp`;
          CREATE TEMPORARY TABLE `webtechtest`.`temp` (rowid INT, transid INT, iscommited INT, oldamount DOUBLE);
          INSERT INTO `temp` (`rowid`,`transid`,`iscommited`, `oldamount`)
          
          SELECT @rownum:=@rownum+1 `rowid`, t.transid, t.iscommited, t.amount from transaction t, (select @rownum:=0) r
          where t.recId = recTransId and t.transDate >= onDate;

          SET @i = (SELECT COUNT(*) FROM temp);
          WHILE (@i > 0) DO
            SET @oldamount = (SELECT t.oldamount FROM `temp` t WHERE rowid = @i);
            SET @transUpdate = (SELECT t.transid FROM temp t WHERE rowid = @i);
            IF ((SELECT t.iscommited FROM temp t WHERE t.rowid = @i) = 1) THEN
              IF @transtype in (2,3) and newamount > @oldamount THEN
                UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
              END IF;
              IF @transtype in (2,3) and newamount < @oldamount THEN
                UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
              END IF;
              IF @transtype in (6,7) and newamount > @oldamount THEN
                UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
              END IF;
              IF @transtype in (6,7) and newamount < @oldamount THEN
                UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
              END IF;
            END IF;

            UPDATE transaction SET `amount` = newamount WHERE transId = @transUpdate;
            SET @i = @i -1;
          END WHILE;
          DROP TABLE IF EXISTS `webtechtest`.`temp`;
           
          WHEN 3 THEN
            SET @transtype = 0;
            SELECT transTypeId INTO @transtype FROM `transaction` t WHERE t.recId = recTransId AND t.transDate = onDate ;
  
            DROP TABLE IF EXISTS `webtechtest`.`temp`;
            CREATE TEMPORARY TABLE `webtechtest`.`temp` (rowid INT, transid INT, iscommited INT, oldamount DOUBLE);
            INSERT INTO `temp` (`rowid`,`transid`,`iscommited`, `oldamount`)
            SELECT @rownum:=@rownum+1 `rowid`, t.transid, t.iscommited, t.amount from `transaction` t, (SELECT @rownum:=0) r
              WHERE t.recId = recTransId;
  
            SET @i = (SELECT COUNT(*) FROM temp);
            WHILE (@i > 0) DO
              SET @oldamount = (SELECT t.oldamount FROM temp t WHERE rowid = @i);
              SET @transUpdate = (SELECT t.transid FROM temp t WHERE rowid = @i);
              SET @diff = abs(newamount - @oldamount);
  
              IF ((SELECT t.iscommited FROM temp t WHERE t.rowid = @i) = 1) THEN
                IF @transtype in (2,3) and newamount > @oldamount THEN
                  UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (2,3) and newamount < @oldamount THEN
                  UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (6,7) and newamount > @oldamount THEN
                  UPDATE wallet SET balance = balance + abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
                IF @transtype in (6,7) and newamount < @oldamount THEN
                  UPDATE wallet SET balance = balance - abs(newamount - @oldamount), lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
                END IF;
              END IF;
              UPDATE transaction SET `amount` = newamount WHERE transId = @transUpdate;
              SET @i = @i -1;
            END WHILE;
            DROP TABLE IF EXISTS `webtechtest`.`temp`;

      END CASE;
    END IF;

ELSE
  select ('Invalid input!');

END IF;
END
$$

--
-- Definition for procedure editUser
--
CREATE 
PROCEDURE editUser(IN loginname VARCHAR(20), IN firstName VARCHAR(20), IN lastName VARCHAR(20), IN DOB DATE, IN email VARCHAR(45), IN userPer VARCHAR(45) )
BEGIN

  IF ( ((SELECT count(*) FROM users u WHERE u.loginname = loginname) > 0) AND
     ( (SELECT count(p.permissionid) FROM permission p WHERE p.name = userPer) > 0) )  THEN 
  
    IF (userPer is not null) THEN
      UPDATE users u SET u.permissionId = (SELECT p.permissionid FROM permission p WHERE p.name = userPer) 
        WHERE u.loginname = loginname; 
    END IF;
    
    IF (firstname is not null) THEN
      UPDATE users u SET u.firstName = firstName WHERE u.loginname = loginname; 
    END IF;
  
    IF (lastName is not null) THEN
      UPDATE users u SET u.lastName = lastName WHERE u.loginname = loginname; 
    END IF;
      
    IF (DOB is not null) THEN
      UPDATE users u SET u.dateOfBirth = DOB WHERE u.loginname = loginname; 
    END IF;
      
    IF (email is not null) THEN
      UPDATE users u SET u.email = email WHERE u.loginname = loginname; 
    END IF;
  
  ELSE
    SELECT 'Loginname or permission is incorrect';
  END IF;



END
$$

--
-- Definition for procedure getAllInvestments
--
CREATE 
PROCEDURE getAllInvestments(IN loginname VARCHAR(20))
BEGIN

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 2);

IF (@uid is null and @wid is null) THEN
  SELECT 'loginname is incorrect';
ELSE
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
  CREATE TEMPORARY TABLE tempRes (invId INT(10), symbol VARCHAR(20), amount double, startDate DATE, value DOUBLE);
  IF (SELECT count(*) FROM investments i WHERE i.walletId = @wid and i.isActive = 1) > 0 THEN
    INSERT INTO tempRes (invId, symbol, amount, startDate, value)
      SELECT i.invId, i.symbol, i.amount, i.startDate, i.value
      FROM investments i
      WHERE i.walletId = @wid and i.isActive = 1;

    select * from tempRes order by invId;
    DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
  ELSE 
    SELECT NULL;
  END IF;
  
END IF;

END
$$

--
-- Definition for procedure getAllMonthlyTransactions
--
CREATE 
PROCEDURE getAllMonthlyTransactions( IN loginname VARCHAR(20), IN monthYear DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

SET @firstDay = DATE_FORMAT(monthYear ,'%Y-%m-01');
SET @lastDay = DATE_FORMAT(last_day(monthYear) ,'%Y-%m-%d');


IF @wid IS NULL OR @uid IS NULL THEN
  SELECT 'Loginname is incorrect';
ELSE
  IF ( ((SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay AND t.walletId = @wid and t.amount > 0) > 0) 
    OR ((SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay AND t.walletId = @wid and (t.amount < 0 OR t.amount IS NULL)) > 0 )
    OR ((SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay and t.walletId = @wid and t.amount IS NULL) > 0) ) THEN
      CREATE TEMPORARY TABLE tempRes (transid INT(10),transname VARCHAR(45), transdate date, amount DOUBLE, transtype VARCHAR(45), description VARCHAR(100));
    
      IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay 
        AND t.walletId = @wid and t.amount > 0) > 0 THEN
        INSERT INTO tempRes (transid, transname, transdate, amount, transtype, description)
        SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
        FROM `transaction` t, transactiontype tt
        WHERE t.transtypeid = tt.typeid and t.transdate between @firstDay and @lastDay 
          and t.walletId = @wid and t.amount > 0;
      END IF;
    
      IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay  
        AND t.walletId = @wid and t.amount < 0) > 0 THEN
        INSERT INTO tempRes (transid, transname, transdate, amount, transtype, description)
        SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
        FROM `transaction` t, transactiontype tt
        WHERE t.transtypeid = tt.typeid and  t.transdate between @firstDay and @lastDay 
          and t.walletId = @wid and t.amount < 0;
      END IF;
    
      IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay 
        and t.walletId = @wid and t.amount IS NULL) > 0 THEN
        INSERT INTO tempRes (transid, transname, transdate, amount, transtype, description)
        SELECT t.transId, t.transCustomName,t.transDate,  t.amount, tt.Name ,t.description
        FROM `transaction` t, transactiontype tt
        WHERE t.transtypeid = tt.typeid and t.transdate between @firstDay and @lastDay 
          and t.walletId = @wid and t.amount IS NULL;
      END IF;
    
      select * from tempRes order by transdate;
      DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
  ELSE
      SELECT 0;
  END IF;
END IF;

END
$$

--
-- Definition for procedure getAllPendingGeneratedPayouts
--
CREATE 
PROCEDURE getAllPendingGeneratedPayouts(IN loginname VARCHAR(20))
BEGIN

DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF @wid = null OR @uid = null THEN
  SELECT null;
ELSE
  CREATE TEMPORARY TABLE tempRes (transname VARCHAR(45), amount DOUBLE, description VARCHAR(100), transDate DATE, transId INT(10));

  IF (SELECT count(*) FROM `Transaction` t WHERE t.transdate < DATE(utc_timestamp()) and t.walletId = @wid and t.isCommited = 0) > 0 THEN
    INSERT INTO tempRes (transname, amount, description, transDate, transId)
    SELECT t.transCustomName, t.amount, t.description, t.transDate, t.transId
    FROM `transaction` t
    WHERE t.transdate < DATE(utc_timestamp()) and t.walletId = @wid and t.isCommited = 0 and t.transTypeId = 7 ;
  END IF;
  select * from tempRes order by transDate;
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
END IF;



END
$$

--
-- Definition for procedure getBalance
--
CREATE 
PROCEDURE getBalance(IN loginname varchar(20))
BEGIN

SET @res = (select w.balance from users u, wallet w where u.loginname = loginname and u.userid = w.userid and wallettype = 1);

IF @res IS NOT NULL THEN
  select @res;
ELSE
  select null;
END IF;

END
$$

--
-- Definition for procedure getDailyOneTimeIncomes
--
CREATE 
PROCEDURE getDailyOneTimeIncomes(IN loginname VARCHAR(20), IN transDate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF @wid IS NULL OR @uid IS NULL THEN
  SELECT null;
ELSE
  CREATE TEMPORARY TABLE tempRes (transId INT(10), transname VARCHAR(45), description VARCHAR(100), amount double);
  IF (SELECT count(*) FROM `transaction` t WHERE t.transdate = transDate and t.walletId = @wid) > 0 THEN
    INSERT INTO tempRes (transid, transname, description, amount)
      SELECT t.transid, t.transCustomName, t.description, t.amount
      FROM `transaction` t
      WHERE t.transdate = transDate and t.walletId = @wid  AND t.transtypeid = 1;
  END IF;
  select * from tempRes order by transid;
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

END IF;

END
$$

--
-- Definition for procedure getDailyOneTimePayouts
--
CREATE 
PROCEDURE getDailyOneTimePayouts(IN loginname VARCHAR(20), IN transDate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF @wid IS NULL OR @uid IS NULL THEN
  SELECT null;
ELSE
  CREATE TEMPORARY TABLE tempRes (transId INT(10), transname VARCHAR(45), description VARCHAR(100), amount double);
  IF (SELECT count(*) FROM `transaction` t WHERE t.transdate = transDate and t.walletId = @wid) > 0 THEN
    INSERT INTO tempRes (transid, transname, description, amount)
      SELECT t.transid, t.transCustomName, t.description, t.amount
      FROM `transaction` t
      WHERE t.transdate = transDate and t.walletId = @wid  AND t.transtypeid = 5;
  END IF;
  select * from tempRes order by transid;
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

END IF;

END
$$

--
-- Definition for procedure getDailyRecurringIncomes
--
CREATE 
PROCEDURE getDailyRecurringIncomes(IN loginname VARCHAR(20), IN transDate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`, `webtechtest`.`temp`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletId from wallet where userId = @uid and wallettype = 1);

IF @wid = null OR @uid = null THEN
  SELECT 0;
ELSE
  CREATE TEMPORARY TABLE tempRes (recId INT(10), recname VARCHAR(45), recType INT(10), description VARCHAR(100), amount double);
  CREATE TEMPORARY TABLE temp (transid INT(10), tDate date);

  IF (SELECT count(*) FROM `recurringtransaction` r, `transaction` t WHERE t.recId = r.recTrans and 
      t.transDate = transDate and r.walletId = @wid and transTypeId = 2 and r.isActive = 1) > 0 THEN

    INSERT INTO temp(transid, tDate)
      SELECT max(t.transid), max(t.transDate)
      FROM transaction t
      WHERE t.recid in (SELECT t.recId from transaction t where t.transDate = transDate and t.walletId = @wid and t.transTypeId = 2 )
      GROUP BY t.recId;

   INSERT INTO tempRes (recId, recname, recType, description, amount)
      SELECT r.recTrans, r.name, t.recurrence, r.description, t.amount
      FROM `recurringtransaction` r, `transaction` t, `temp` tt
      WHERE r.recTrans = t.recId AND t.transId = tt.transid AND r.isActive = 1;

  END IF;
  select * from tempRes order by recId ;
DROP TABLE IF EXISTS `webtechtest`.`tempRes`, `webtechtest`.`temp`;

END IF;
END
$$

--
-- Definition for procedure getDailyRecurringPayouts
--
CREATE 
PROCEDURE getDailyRecurringPayouts(IN loginname VARCHAR(20), IN transDate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`, `webtechtest`.`temp`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletId from wallet where userId = @uid and wallettype = 1);

IF @wid = null OR @uid = null THEN
  SELECT 0;
ELSE
  CREATE TEMPORARY TABLE tempRes (recId INT(10), recname VARCHAR(45), recType INT(10), description VARCHAR(100), amount double, noteDate DATE);
  CREATE TEMPORARY TABLE temp (transid INT(10), tDate date);

  IF (SELECT count(*) FROM `recurringtransaction` r, `transaction` t WHERE t.recId = r.recTrans and 
      t.transDate = transDate and r.walletId = @wid and transTypeId in (6,7) and r.isActive = 1 ) > 0 THEN

    INSERT INTO temp(transid, tDate)
      SELECT max(t.transid), max(t.transDate)
      FROM transaction t
      WHERE t.recid in (SELECT t.recId from transaction t where t.transDate = transDate and t.walletId = @wid and t.transTypeId in (6,7) )
      GROUP BY t.recId;
   
   INSERT INTO tempRes (recId, recname, recType, description, amount, noteDate)
      SELECT r.recTrans, r.name, t.recurrence, r.description, t.amount, null
      FROM `recurringtransaction` r, `transaction` t, `temp` tt
      WHERE r.recTrans = t.recId AND t.transId = tt.transid and r.isActive = 1 
        and r.recTrans NOT IN (select n.recId from notifications n);
   INSERT INTO tempRes (recId, recname, recType, description, amount, noteDate)
     SELECT r.recTrans, r.name, t.recurrence, r.description, t.amount, n.lastNoteDate
     FROM `recurringtransaction` r, `transaction` t, `temp` tt, notifications n
     WHERE r.recTrans = t.recId AND t.transId = tt.transid and r.isActive = 1 and r.recTrans = n.recId;

  END IF;
  select * from tempRes order by recId ;
DROP TABLE IF EXISTS `webtechtest`.`tempRes`, `webtechtest`.`temp`;

END IF;
END
$$

--
-- Definition for procedure getDailyTransactions
--
CREATE 
PROCEDURE getDailyTransactions(IN loginname VARCHAR(20), IN todaydate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`, `tempTrans`, `tempJH`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF @wid = null OR @uid = null THEN
  SELECT null;
ELSE
  CREATE TEMPORARY TABLE tempRes (transid INT(10),transname VARCHAR(45), amount DOUBLE, transtype VARCHAR(45), description VARCHAR(100));
  CREATE TEMPORARY TABLE tempTrans (transid INT(10), recid int(10) );
  CREATE TEMPORARY TABLE tempJH (recId INT(10), startH datetime, endH datetime, wage double );
#--------------------- Select all transactions except from salaries ---------------------------------------------#
  IF (SELECT count(*) FROM `transaction` t WHERE t.transdate = todaydate and t.walletId = @wid and t.transTypeId <> 3) > 0 THEN
    INSERT INTO tempRes (transid, transname, amount, transtype, description)
    SELECT t.transId, t.transCustomName, t.amount, tt.Name ,t.description
    FROM `transaction` t, transactiontype tt
    WHERE t.transtypeid = tt.typeid and t.transdate = todaydate and t.walletId = @wid and t.transTypeId <> 3;
  END IF;
#--------------------- Select salaries and calculate them  ---------------------------------------------#

  IF (SELECT count(*) FROM `transaction` t WHERE t.transdate = todaydate and t.walletId = @wid and t.transTypeId = 3 ) > 0 THEN
     #-------------- Get transactions to calculate -------------------#
     INSERT INTO tempTrans (transId, recid)
      SELECT t.transId,t.recId FROM transaction t 
      WHERE t.transdate = todaydate and t.walletId = @wid and t.transTypeId = 3 and t.amount is null;
     SET @count = row_count();
     
     WHILE (@count > 0 ) DO
  
        SELECT transid, recid INTO @trans, @rec FROM tempTrans LIMIT 1;
        IF (SELECT count(*) FROM jobhours jh WHERE jh.recId = @rec and jh.walletId = @wid and jh.isCalculated = 0 and jh.endHour < todaydate ) > 0 THEN
    
            INSERT INTO tempJH (recId, startH, endH, wage)
              SELECT jh.recId, jh.startHour, jh.endHour, rt.wage
              FROM jobhours jh, recurringtransaction rt WHERE jh.recId = @rec and rt.recTrans = @rec and jh.walletId = @wid and jh.isCalculated = 0 and jh.endHour < todaydate;
            SET @rows = row_count();
            
            IF (@rows > 0 ) THEN
              SET @amount = 0;
              
              WHILE (@rows > 0) DO
                SELECT startH, endH, wage INTO @start, @end, @wage FROM tempJH LIMIT 1 ;
                SET @amount = @amount + calcSalaryHourWage(@start,@end, @wage );
                DELETE FROM tempJH LIMIT 1;
                SET @rows = (SELECT count(*) FROM tempJH);
    
              END WHILE;
              
              INSERT INTO tempRes (transid, transname, amount, transtype, description)
                SELECT t.transId, t.transCustomName, @amount, tt.Name ,t.description
                FROM `transaction` t, transactiontype tt
                WHERE t.transtypeid = tt.typeid and t.transId = @trans;
            END IF;
          END IF;
          DELETE FROM tempTrans LIMIT 1;
          SET @count = (SELECT count(*) FROM tempTrans);
       
   END WHILE;

 #-------------- Get transactions calculated -------------------#
  IF (SELECT count(*) FROM `transaction` t WHERE t.transdate = todaydate and t.walletId = @wid and  t.transTypeId = 3 and t.amount IS NOT NULL) > 0 THEN
    INSERT INTO tempRes (transid, transname, amount, transtype, description)
    SELECT t.transId, t.transCustomName, t.amount, tt.Name ,t.description
    FROM `transaction` t, transactiontype tt
    WHERE t.transtypeid = tt.typeid and t.transdate = todaydate and t.walletId = @wid and t.transTypeId = 3 and t.amount IS NOT NULL;
  END IF;

  END IF;

  select * from tempRes order by amount desc;
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
END IF;

END
$$

--
-- Definition for procedure getDailyWorkHours
--
CREATE 
PROCEDURE getDailyWorkHours(IN loginname varchar(20), IN transDate DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF @wid = null OR @uid = null THEN
  SELECT null;
ELSE
  CREATE TEMPORARY TABLE tempRes (transname VARCHAR(45), description VARCHAR(100), startHour DATETIME, endHour DATETIME);
  IF (SELECT count(*) FROM `jobhours` j WHERE (DATE(j.startHour) = transDate OR DATE(endHour) = transDate )AND j.walletId = @wid ) > 0 THEN

    INSERT INTO tempRes (transname, description, startHour, endHour)
      SELECT r.name, j.description, j.startHour, j.endHour
      FROM  jobhours j, recurringtransaction r
      WHERE j.recId = r.recTrans AND transdate = DATE(j.startHour) AND DATE(j.endHour) = DATE(j.startHour) AND j.walletId = @wid ;

    INSERT INTO tempRes (transname, description, startHour, endHour)
      SELECT r.name, j.description, j.startHour, TIMESTAMP(DATE(j.endHour))
      FROM  jobhours j, recurringtransaction r
      WHERE j.recId = r.recTrans AND DATE(j.endHour) <> DATE(j.startHour)
        AND transdate = DATE(j.startHour) AND DATE(j.startHour) < DATE(j.endHour) AND j.walletId = @wid ;

    INSERT INTO tempRes (transname, description, startHour, endHour)
      SELECT r.name, j.description, TIMESTAMP(DATE(j.startHour + interval 1 day)), j.endHour
      FROM  jobhours j, recurringtransaction r
      WHERE j.recId = r.recTrans AND DATE(j.endHour) <> DATE(j.startHour)
        AND transdate = DATE(j.endHour) AND DATE(j.startHour) < DATE(j.endHour) AND j.walletId = @wid ;


  END IF;
  select * from tempRes order by startHour;
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;

END IF;

END
$$

--
-- Definition for procedure getInvestment
--
CREATE 
PROCEDURE getInvestment(IN loginname VARCHAR(20),IN symbol VARCHAR(20))
BEGIN

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 2);

IF (@uid is null and @wid is null) THEN
  SELECT 'loginname is incorrect';
ELSE
  DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
  CREATE TEMPORARY TABLE tempRes (invId INT(10), symbol VARCHAR(20), amount double, startDate DATE, value DOUBLE);
  IF (SELECT count(*) FROM investments i WHERE i.symbol = symbol and i.walletId = @wid and i.isActive = 1) > 0 THEN
    INSERT INTO tempRes (invId, symbol, amount, startDate, value)
      SELECT i.invId, i.symbol, i.amount, i.startDate, i.value
      FROM investments i
      WHERE i.symbol = symbol and i.walletId = @wid and i.isActive = 1;

    select * from tempRes order by invId;
    DROP TABLE IF EXISTS `webtechtest`.`tempRes`;
  ELSE 
    SELECT NULL;
  END IF;
  
END IF;

END
$$

--
-- Definition for procedure getJobs
--
CREATE 
PROCEDURE getJobs(IN loginname varchar(20))
BEGIN

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF (@wid > 0 )THEN

  SELECT r.recTrans, r.name, r.wage, r.incomeDate, r.description FROM recurringtransaction r WHERE r.walletId = @wid and r.incomeDate IS NOT NULL and r.isActive = 1;

ELSE

  SELECT "loginname is incorrect";
END IF;



END
$$

--
-- Definition for procedure getTopMonthlyTransactions
--
CREATE 
PROCEDURE getTopMonthlyTransactions( IN loginname VARCHAR(20), IN monthYear DATE)
BEGIN
DROP TABLE IF EXISTS `webtechtest`.`result`, `tempPay`, `tempInc` ;

SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

SET @firstDay = DATE_FORMAT(monthYear ,'%Y-%m-01');
SET @lastDay = DATE_FORMAT(last_day(monthYear) ,'%Y-%m-%d');


IF @wid IS NULL OR @uid IS NULL THEN
  SELECT 'Loginname is incorrect';
ELSE
  IF ( ((SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay AND t.walletId = @wid and t.amount > 0) > 0) 
    OR ((SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay AND t.walletId = @wid and (t.amount < 0 OR t.amount IS NULL)) > 0 ))THEN
    CREATE TEMPORARY TABLE result (transid INT(10),transname VARCHAR(45), transdate date, amount DOUBLE, transtype VARCHAR(45), description VARCHAR(100));
    CREATE TEMPORARY TABLE tempPay (transid INT(10),transname VARCHAR(45), transdate date, amount DOUBLE, transtype VARCHAR(45), description VARCHAR(100));
    CREATE TEMPORARY TABLE tempInc (transid INT(10),transname VARCHAR(45), transdate date, amount DOUBLE, transtype VARCHAR(45), description VARCHAR(100));
  
    IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay 
      AND t.walletId = @wid and t.amount > 0) > 0 THEN
      INSERT INTO tempInc (transid, transname, transdate, amount, transtype, description)
      SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
      FROM `transaction` t, transactiontype tt
      WHERE t.transtypeid = tt.typeid and t.transdate between @firstDay and @lastDay 
        and t.walletId = @wid and t.amount > 0 and t.recId IS NULL;
    END IF;
    IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay 
      AND t.walletId = @wid and t.amount > 0) > 0 THEN
      INSERT INTO tempInc (transid, transname, transdate, amount, transtype, description)
      SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
      FROM `transaction` t, transactiontype tt, recurringtransaction rt
      WHERE  t.recId = rt.recTrans AND
      t.transtypeid = tt.typeid and t.transdate between @firstDay and @lastDay 
        and t.walletId = @wid and t.amount > 0 and t.recId IS NOT NULL;
    END IF;
  
    IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay  
      AND t.walletId = @wid and (t.amount < 0 OR t.amount IS NULL)) > 0 THEN
      INSERT INTO tempPay (transid, transname, transdate, amount, transtype, description)
      SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
      FROM `transaction` t, transactiontype tt
      WHERE t.transtypeid = tt.typeid and  t.transdate between @firstDay and @lastDay 
        and t.walletId = @wid and t.recId IS NULL and (t.amount < 0 OR t.amount IS NULL);
    END IF;
     IF (SELECT count(*) FROM `transaction` t WHERE t.transdate between @firstDay and @lastDay  
      AND t.walletId = @wid and (t.amount < 0 OR t.amount IS NULL)) > 0 THEN
      INSERT INTO tempPay (transid, transname, transdate, amount, transtype, description)
      SELECT t.transId, t.transCustomName, t.transDate, t.amount, tt.Name ,t.description
      FROM `transaction` t, transactiontype tt, recurringtransaction rt
      WHERE  t.recId = rt.recTrans AND
      t.transtypeid = tt.typeid and  t.transdate between @firstDay and @lastDay 
        and t.walletId = @wid and t.recId IS NOT NULL and (t.amount < 0 OR t.amount IS NULL) ;
    END IF;
    INSERT INTO result
      select * from tempInc order by amount desc limit 5;
    INSERT INTO result
      select * from tempPay order by amount limit 5;

    SELECT * from `result`;    

    DROP TABLE IF EXISTS `webtechtest`.result, `webtechtest`.`tempInc`,`webtechtest`.`tempPay`;

  ELSE
    SELECT NULL;
  END IF;
END IF;

END
$$

--
-- Definition for procedure getTransToDelete
--
CREATE 
PROCEDURE getTransToDelete(IN monthYear DATE, IN loginname VARCHAR(20))
BEGIN
  SET @uid = (SELECT userid FROM users u where u.loginname = loginname );
  SET @wid = (SELECT walletid FROM wallet w WHERE w.userId = @uid AND w.wallettype = 1);

IF ( @uid IS NOT NULL AND monthYear IS NOT NULL ) THEN
  
  SET @firstday = DATE_FORMAT(monthYear ,'%Y-%m-01');
  SET @lastDay = DATE_FORMAT(last_day(monthYear) ,'%Y-%m-%d');

  DROP TABLE IF EXISTS `webtechtest`.`result` , `webtechtest`.`rectemp`, `webtechtest`.`jobtemp`;

  CREATE TEMPORARY TABLE `webtechtest`.`result` (`recid` INT, jobhourid INT, transid INT, transname VARCHAR(40), amount DOUBLE, transdate DATE, iscommited INT);
  CREATE TEMPORARY TABLE `webtechtest`.`jobtemp` (`recid` INT, jobhourid INT, starthour DATETIME, endHour DATETIME);
  CREATE TEMPORARY TABLE `webtechtest`.`rectemp` (`recid` INT, `recname` VARCHAR(40));

#--------------------   Insert all ONE TIME transactions   ----------------------------------#
  INSERT INTO `webtechtest`.`result` (recid, jobhourid, transid, transname , amount , transdate, iscommited )
    SELECT  null, null, t.transid, t.transCustomName, t.amount, t.transDate, t.iscommited 
    FROM `webtechtest`.`transaction` t
    WHERE t.walletId = @wid AND t.recId IS NULL AND t.recurrence = 9 
    AND t.transDate BETWEEN @firstday AND @lastDay 
    ORDER BY 1 ASC;
#--------------------  Insert all RECURRING transactions NOT JOBS #TEMP# --------------------------------#
 INSERT INTO `webtechtest`.`rectemp` (`recid`,`recname`)
    SELECT rt.recTrans as recid, rt.`name` from transaction t, recurringtransaction rt
      where t.recId = rt.recTrans 
      and rt.walletId = @wid 
      and rt.incomeDate IS NULL
      and rt.isActive = 1
      and t.transDate between @firstday and @lastDay
      group by rt.recTrans;

  SET @rows = row_count();
  #---------------------  Insert all transactions related to RECURRING #RESULT#  --------------------------------#
    WHILE (@rows > 0) DO
      SET @rec =  (SELECT r.recid from `rectemp` r limit 1);
      INSERT INTO `webtechtest`.`result` (recid, jobhourid, transid, transname , amount , transdate, iscommited )
      SELECT  r.recid, null, null, r.recname, null, null, null from `rectemp` r
        where r.recid = @rec;
  
      INSERT INTO `webtechtest`.`result` (recid, jobhourid, transid, transname , amount , transdate, iscommited )
      SELECT  t.recid, null, t.transId, t.transCustomName, t.amount, t.transDate, t.isCommited from transaction t
        where t.recId = @rec and t.transDate between @firstday and @lastDay order by t.transDate asc;

      DELETE FROM `rectemp` WHERE recid = @rec;
      SET @rows = (SELECT count(*) FROM `rectemp`);
    END WHILE;

#--------------------- Insert all Recurring transactions - that have Job hours related #TEMP#  --------------------------------#
  INSERT INTO `webtechtest`.`jobtemp` (`recid` , jobhourid , starthour , endHour )
    SELECT  j.recId, j.jobHoursId, j.startHour, j.endHour  from `jobhours` j, recurringtransaction rt
      where j.recId = rt.recTrans and j.walletId = @wid and date(j.endHour) >= @firstday and date(j.starthour) <= @lastDay
      and  rt.isActive = 1
      GROUP BY j.recId
      order by 1 asc;

  SET @rows = row_count();
#--------------------- Insert all Job hours related to RECURRING  #RESULT#  --------------------------------#
   WHILE (@rows > 0) DO    
    SET @rec =  (SELECT j.recid from `jobtemp` j limit 1);
    #---Insert the label of the work ---#
    INSERT INTO `webtechtest`.`result` (recid, jobhourid, transid, transname , amount , transdate, iscommited )
    SELECT  rt.recTrans, null, null, rt.name, null, rt.incomeDate, null 
      FROM `recurringtransaction` rt
      WHERE rt.recTrans = @rec;

    #---Insert the hours of the work ---#
    INSERT INTO `webtechtest`.`result` (recid, jobhourid, transid, transname , amount , transdate, iscommited )
    SELECT  jh.recid, jh.jobHoursId, null, 
            concat(DATE_FORMAT(jh.starthour ,'%d/%m/%Y, %H:%i'), ' - ', DATE_FORMAT(jh.endhour ,'%d/%m/%Y, %H:%i')),
            null, null, jh.isCalculated 
            FROM jobhours jh
            WHERE jh.recId = @rec AND date(jh.endHour) >= @firstday and date(jh.starthour) <= @lastDay 
            order by jh.jobHoursId;


     DELETE FROM `jobtemp` WHERE recid = @rec;
     SET @rows = (SELECT count(*) FROM `jobtemp`);
  END WHILE;

IF (( SELECT count(*) FROM `webtechtest`.`result`) > 0 ) then
  SELECT * FROM `webtechtest`.`result`;
ELSE
  Select 0;
END IF;
ELSE
  SELECT 'Username or Date is incorrect!';
END IF;
 #DROP TABLE IF EXISTS `webtechtest`.`result` ,  `webtechtest`.`rectemp`, `webtechtest`.`jobtemp`;
END
$$

--
-- Definition for procedure getUserInfo
--
CREATE 
PROCEDURE getUserInfo(IN loginname VARCHAR(20))
BEGIN

  IF (SELECT count(*) FROM users u WHERE u.loginname= loginname) > 0 THEN 
  
    SELECT u.firstName, u.lastName, p.name , u.dateOfBirth, u.email, u.statusChangeComment, u.statusId FROM users u, permission p 
    WHERE u.permissionId = p.permissionId AND u.loginname = loginname;
  
  ELSE
    SELECT -1;
  END IF;

END
$$

--
-- Definition for procedure getWage
--
CREATE 
PROCEDURE getWage(IN recId INT(10))
BEGIN


IF recId > 0 THEN
  select wage from recurringtransaction r where recTrans = recId;
ELSE
  SELECT "Incorrect ID";

END IF;
END
$$

--
-- Definition for procedure insertJob
--
CREATE 
PROCEDURE insertJob(IN loginname varchar(20), IN jobcustomname varchar(45), IN description varchar(100), IN wage DOUBLE, IN incomeDate DATE)
BEGIN
SET @uid = (select u.userId from users u where u.loginname = loginname);
SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

IF (jobcustomname is null or wage <= 0 or incomeDate is null or @wid is null or @uid is null OR incomeDate < date(utc_timestamp()) ) THEN
  SELECT "Inserted details are incorrect";
ELSE
  INSERT INTO `webtechtest`.recurringtransaction (`name`, `description`, `wage`,`incomeDate`, `walletId`)
		VALUES(jobcustomname, description, wage, incomeDate, @wid);
  SET @rec = last_insert_id();
  INSERT INTO `webtechtest`.`transaction` (amount,transDate,isCommited,walletId,transTypeId,transCustomName,recurrence,description,recId,wage)
    VALUES (null,incomeDate,0, @wid, 3, jobcustomname, 4, description,@rec,wage);
  SELECT 0;

END IF;
END
$$

--
-- Definition for procedure insertOneTimeTrans
--
CREATE 
PROCEDURE insertOneTimeTrans(IN amount DOUBLE, IN loginname varchar(20), IN transdate DATE, IN transcustomname varchar(45), IN transactiontypeid int(10), IN description VARCHAR(100))
BEGIN

 SET @wid = (select w.walletid from users u, wallet w where u.loginname = loginname and u.userid = w.userid and w.wallettype = 1);

 IF @wid IS NOT NULL THEN

    IF transactiontypeid in (1,5) THEN
      IF (transdate <= (SELECT DATE(utc_timestamp())) ) THEN
        INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` , `description`, `recid`)
		      VALUES ( amount,  transdate, 1, @wid, transactiontypeid, transcustomname, 9 , description, null);

        UPDATE wallet SET balance = balance+amount, lastUpdateDate = utc_timestamp()  where walletid = @wid;
        select 0;
      ELSE
        INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` ,`description`, `recid`)
          VALUES ( amount,  transdate, 0, @wid, transactiontypeid, transcustomname, 9, description, null);
        select 0;

      END IF;

    END IF;

  ELSE
      select "User doesn't have a wallet";

  END IF;


END
$$

--
-- Definition for procedure insertRecurringTrans
--
CREATE 
PROCEDURE insertRecurringTrans(IN amount DOUBLE, IN loginname varchar(20), IN transdate DATE, IN transcustomname varchar(45), IN recurrence varchar(45), IN transtypeid INT(10), IN firstNote DATE, IN description VARCHAR(100))
BEGIN
  SET @trans = 0;
  SET @tempdate = transdate;
  SET @tempnote = firstNote;

  SET @uid = (select u.userId from users u where u.loginname = loginname);
  SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);

  IF (@uid = NULL OR @wid = NULL) THEN SELECT "Username doesn't exist";
  END IF;
  IF recurrence = 9 OR transtypeid NOT IN (2,6,7) THEN SELECT "Not a recurring transaction";
  END IF;


	IF (recurrence != 9 AND @wid IS NOT NULL AND @uid IS NOT NULL) THEN
    
		IF transtypeid in (2, 6) THEN                       

			IF (transdate <= date(utc_timestamp()) ) THEN     
        INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence`, `description` )
					VALUES ( amount,  @tempdate, 1, @wid, transtypeid, transcustomname, recurrence, description);
				SET @trans = LAST_INSERT_ID();
				INSERT INTO `webtechtest`.recurringtransaction (`name`, `description`, `walletID`)
					VALUES(transcustomname, description, @wid);
				SET @rec = LAST_INSERT_ID();
				UPDATE `transaction` SET recId = @rec WHERE transid = @trans;
				UPDATE wallet SET balance = balance+amount, lastUpdateDate = utc_timestamp()  where walletid = @wid;

      	CASE recurrence
			    WHEN 10 THEN
				  	SET @tempdate = @tempdate + INTERVAL 1 day;
            SET @tempnote = @tempnote + INTERVAL 1 day;
  			  WHEN 1 THEN
	  				SET @tempdate = @tempdate + INTERVAL 1 week;
            SET @tempnote = @tempnote + INTERVAL 1 week;
		  	  WHEN 2 THEN
			  		SET @tempdate = @tempdate + INTERVAL 2 week;
            SET @tempnote = @tempnote + INTERVAL 2 week;
  			  WHEN 4 THEN
            IF @tempdate = LAST_DAY(@tempdate) THEN
	  			  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 1 month);
              SET @tempnote = LAST_DAY(@tempnote + INTERVAL 1 month);
            ELSE
            	SET @tempdate = @tempdate + INTERVAL 1 month;
              SET @tempnote = @tempnote + INTERVAL 1 month;
            END IF;
		  	  WHEN 8 THEN
            IF @tempdate = LAST_DAY(@tempdate) THEN
	  			  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 2 month);
              SET @tempnote = LAST_DAY(@tempnote + INTERVAL 2 month);
            ELSE
            	SET @tempdate = @tempdate + INTERVAL 2 month;
              SET @tempnote = @tempnote + INTERVAL 2 month;
            END IF;
        END CASE;

				WHILE (@tempdate <= date(utc_timestamp())) DO
					INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence`, `description` )
						VALUES ( amount,  @tempdate, 1, @wid, transtypeid, transcustomname, recurrence, description);
					SET @trans = LAST_INSERT_ID();
					UPDATE wallet SET balance = balance+amount, lastUpdateDate = utc_timestamp()  where walletid = @wid;
      	  UPDATE `transaction` SET recId = @rec WHERE transid = @trans;

					CASE recurrence
			      WHEN 10 THEN
				    	SET @tempdate = @tempdate + INTERVAL 1 day;
              SET @tempnote = @tempnote + INTERVAL 1 day;
    			  WHEN 1 THEN
	    				SET @tempdate = @tempdate + INTERVAL 1 week;
              SET @tempnote = @tempnote + INTERVAL 1 week;
		    	  WHEN 2 THEN
			    		SET @tempdate = @tempdate + INTERVAL 2 week;
              SET @tempnote = @tempnote + INTERVAL 2 week;
  		  	  WHEN 4 THEN
             IF @tempdate = LAST_DAY(@tempdate) THEN
	  	  		  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 1 month);
                SET @tempnote = LAST_DAY(@tempnote + INTERVAL 1 month);
              ELSE
              	SET @tempdate = @tempdate + INTERVAL 1 month;
                SET @tempnote = @tempnote + INTERVAL 1 month;
              END IF;
		    	  WHEN 8 THEN
              IF @tempdate = LAST_DAY(@tempdate) THEN
	  		  	  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 2 month);
                SET @tempnote = LAST_DAY(@tempnote + INTERVAL 2 month);
              ELSE
              	SET @tempdate = @tempdate + INTERVAL 2 month;
                SET @tempnote = @tempnote + INTERVAL 2 month;
              END IF;          END CASE;

				END WHILE;

				IF (@tempdate > date(utc_timestamp()) ) THEN
				  INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` ,`description`)
						VALUES ( amount,  @tempdate, 0, @wid, transtypeid, transcustomname, recurrence, description);
				  SET @trans = LAST_INSERT_ID();
				  UPDATE `transaction` SET recId = @rec WHERE transid = @trans;
				END IF;

			ELSE 

				INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` ,`description`)
					  VALUES ( amount,  @tempdate, 0, @wid, transtypeid, transcustomname, recurrence, description);
				SET @trans = LAST_INSERT_ID();
				INSERT INTO webtechtest.recurringtransaction (`name`, `description`, `walletID`)
					VALUES(transcustomname, description, @wid);
				SET @rec = LAST_INSERT_ID();
				UPDATE `transaction` SET recId = @rec WHERE transid = @trans;

			END IF; 


			IF transtypeid in (6) and firstNote is NOT NULL THEN
				INSERT INTO `webtechtest`.`notifications` (`firstnotedate`,`lastnotedate`,`walletid`,`recid`)
					VALUES(null, @tempnote, @wid, @rec);
			END IF;
		select 0;
		END IF;
 
    
		IF transtypeid in (7) THEN
			IF (transdate <=  date(utc_timestamp()) ) THEN
				INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence`, `description`)
					VALUES ( amount,  transdate, 1, @wid, transtypeid, transcustomname, recurrence, description);
				SET @trans = LAST_INSERT_ID();
				 
				INSERT INTO `webtechtest`.`recurringtransaction` (`name`, `description`, `walletID`)
					VALUES(transcustomname, description, @wid);
				SET @rec = LAST_INSERT_ID();
				UPDATE `transaction` SET recId = @rec WHERE transid = @trans;
				UPDATE wallet SET balance = balance+amount, lastUpdateDate = utc_timestamp() where walletid = @wid;

	  		CASE recurrence
		      WHEN 10 THEN
            SET @tempdate = @tempdate + INTERVAL 1 day;
            SET @tempnote = @tempnote + INTERVAL 1 day;
    		  WHEN 1 THEN
            SET @tempdate = @tempdate + INTERVAL 1 week;
            SET @tempnote = @tempnote + INTERVAL 1 week;
		   	 WHEN 2 THEN
            SET @tempdate = @tempdate + INTERVAL 2 week;
            SET @tempnote = @tempnote + INTERVAL 2 week;
  			  WHEN 4 THEN
            IF @tempdate = LAST_DAY(@tempdate) THEN
	  			  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 1 month);
              SET @tempnote = LAST_DAY(@tempnote + INTERVAL 1 month);
            ELSE
            	SET @tempdate = @tempdate + INTERVAL 1 month;
              SET @tempnote = @tempnote + INTERVAL 1 month;
            END IF;
		  	  WHEN 8 THEN
            IF @tempdate = LAST_DAY(@tempdate) THEN
	  			  	SET @tempdate = LAST_DAY(@tempdate + INTERVAL 2 month);
              SET @tempnote = LAST_DAY(@tempnote + INTERVAL 2 month);
            ELSE
            	SET @tempdate = @tempdate + INTERVAL 2 month;
              SET @tempnote = @tempnote + INTERVAL 2 month;
            END IF;
         END CASE;

         IF (@tempdate >= date(utc_timestamp()) ) THEN
					INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` , `description`)
						VALUES ( null,  @tempdate, 0, @wid, transtypeid, transcustomname, recurrence, description);
					SET @trans = LAST_INSERT_ID();
					UPDATE `transaction` SET recId = @rec WHERE transid = @trans;
				 END IF;

				 INSERT INTO `webtechtest`.`notifications` (`firstnotedate`,`lastnotedate`,`walletid`,`recid`)
					VALUES(@tempnote, @tempdate - INTERVAL 3 day, @wid, @rec);
			ELSE
				INSERT INTO `webtechtest`.`transaction` ( `amount`, `transdate`, `iscommited`, `walletid`, `transtypeid`, `transcustomname`, `recurrence` ,`description`)
				  VALUES ( null,  transdate, 0, @wid, transtypeid, transcustomname, recurrence, description);
				SET @trans = LAST_INSERT_ID();
				
				INSERT INTO `webtechtest`.`recurringtransaction` (`name`, `description`, `walletID`)
					VALUES(transcustomname, description, @wid);
        SET @rec = LAST_INSERT_ID();
				UPDATE `transaction` SET recId = @rec WHERE transid = @trans;
				
				INSERT INTO `webtechtest`.`notifications` (`firstnotedate`,`lastnotedate`,`walletid`,`transid`)
				  VALUES(@tempnote, @tempdate - INTERVAL 3 day, @wid, @rec);
				  
		  END IF;
		select 0;
		END IF;

	END IF;
END
$$

--
-- Definition for procedure insertTransaction
--
CREATE 
PROCEDURE insertTransaction(IN amount DOUBLE, IN loginname varchar(20), IN transdate DATE, IN transcustomname varchar(45), IN recurrance varchar(45), IN transtypeid INT(10), IN firstNote DATE, IN description VARCHAR(100))
BEGIN

IF (amount = null OR loginname = null OR transdate = null OR (transtypeid not between 1 and 7)) THEN
  select 'Failed on insertTransaction';
ELSE
  IF transtypeid in (1,5) THEN
    CALL insertOneTimeTrans(amount, loginname, transdate, transcustomname, transtypeid, description);
  ELSE
    CALL insertRecurringTrans(amount, loginname, transdate, transcustomname,recurrance, transtypeid, firstNote, description);


  END IF;


END IF;

END
$$

--
-- Definition for procedure installDB
--
CREATE 
PROCEDURE installDB(IN username VARCHAR(20), IN pass VARCHAR(45), IN addData TINYINT)
BEGIN

IF (username IS NULL or pass IS NULL or addData < 0 or addData > 1 ) THEN
  SELECT 'incorrect details';
ELSE
# ----------- Clear all -------------# 
-- 
-- Disable foreign keys
-- 
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 ;
  truncate notifications;
  truncate jobhours;
  truncate transaction;
  truncate recurringtransaction;
  truncate investments;
  truncate wallet;
  truncate users;
-- 
-- Enable foreign keys
-- 
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
# ----------- Add data -------------# 
    call register(username, 'admin', 'test', DATE(utc_timestamp()), 3, 'email@mail.d', pass);
	select 1;
	select 1;
    IF (addData = 1) THEN
      DROP TABLE IF EXISTS temp;
      CREATE TEMPORARY TABLE temp (username VARCHAR(20));

      call register('demoRegular', 'demo', 'Regular', DATE(utc_timestamp()), 1, 'email@mail.b', pass);
      call register('demoPremium', 'demo', 'Premium', DATE(utc_timestamp()), 2, 'email@mail.c', pass);
      
      INSERT INTO temp (username)
        SELECT u.loginname FROM users u;
      SET @rows = row_count();

      WHILE (@rows > 0) DO
        SET @username = (select u.username FROM temp u LIMIT 1);

          SET @uid = (select u.userId from users u where u.loginname = @username);
          SET @wid = (select walletid from wallet where userid = @uid and wallettype = 1);
    
          #Insert one time incomes
          SET @count = 4;
          SET @tempdate = utc_timestamp();
          WHILE (@count > 0 ) DO
            call insertTransaction(@count*3, @username, @tempDate, 'one time income - auto', 9,1,null,'auto - one time income description');
            set @tempDate = @tempdate - interval @count week;
            SET @count = @count - 1;
          END WHILE;
          
          #Insert one time payouts
          SET @count = 5;
          SET @tempdate = utc_timestamp();
          WHILE (@count > 0 ) DO
            call insertTransaction(-(@count*3), @username, @tempDate, 'one time payout - auto', 9,5,null,'auto - one time payout description');
            set @tempDate = @tempdate - interval @count month;
            SET @count = @count - 1;
          END WHILE;
    
          #Insert recurring incomes
          SET @count = 2;
          SET @tempdate = utc_timestamp() - interval 11 month;
          WHILE (@count > 0 ) DO
            call insertTransaction(@count*(FLOOR(100 + (RAND() * 200))), @username, @tempDate, 'recurring income - auto', 4,2,null,'auto - recurring income description');
            set @tempDate = @tempdate + interval @count month;
            SET @count = @count - 1;
          END WHILE;
          
          #Insert recurring payouts
          SET @count = 2;
          SET @tempdate = utc_timestamp() - interval 10 month;
          WHILE (@count > 0 ) DO
            call insertTransaction(-(@count*110), @username, @tempDate, 'recurring payouts - auto', 2,6,null,'auto - recurring payouts description');
            call insertTransaction(-(@count*137), @username, @tempDate, 'recurring payouts with notification - auto', 2,6, @tempDate,'auto - recurring payouts  with notification description');
            set @tempDate = @tempdate + interval @count week;
            SET @count = @count - 1;
          END WHILE;
          
          #Insert jobs
          SET @count = 2;
          SET @tempdate = utc_timestamp();
          WHILE (@count > 0 ) DO
            call insertJob(@username, concat('Job name ', @count), concat('Desc name ',@count), 25.7+@count, @tempdate);
            SET @count = @count - 1;
          END WHILE;
        DELETE FROM temp LIMIT 1;
        SET @rows = (select count(*) from temp);

      END WHILE;

      #Insert job hours
      DROP TABLE IF EXISTS tempWallets;
      CREATE TEMPORARY TABLE tempWallets (walletId INT(11));
      
      INSERT INTO tempWallets(`walletId`) SELECT walletId FROM wallet;
      
      SET @rows = (select count(*) from tempWallets);
      #while users > 0
      WHILE (@rows > 0) DO
        SELECT tw.walletId INTO @wid FROM tempWallets tw LIMIT 1;
        SET @recid = (select rt.recTrans from recurringtransaction rt where rt.incomeDate IS NOT NULL and rt.wage > 0 and rt.walletId = @wid limit 1);
        SET @month = 2;
        #2 months count
        WHILE (@month > 0) DO
          SET @days = 14;
          #14 days of work a month
          WHILE (@days > 0 ) DO
            CALL updateWorkingHours(@recid, utc_timestamp() - interval @days day - interval @month month - interval 5 hour,utc_timestamp() - interval @days day - interval @month month , 'AUTO- Salary');
            SET @days = @days - 1;
          END WHILE;

          SET @month = @month - 1;
          CALL commitJobHours();
        END WHILE;
        
        DELETE FROM tempWallets LIMIT 1;
        SET @rows = (select count(*) from tempWallets);
        
      END WHILE;

    END IF;
END IF;
DROP TABLE IF EXISTS temp;
END
$$

--
-- Definition for procedure register
--
CREATE 
PROCEDURE register(IN loginname VARCHAR(20), IN firstname VARCHAR(20), IN lastname VARCHAR(20), IN dateOfBirth Date, IN permissionId INT(10), IN email VARCHAR(45), IN pincode VARCHAR(45))
BEGIN


    SET @res = (SELECT COUNT(*) FROM webtechtest.users u WHERE u.loginname = loginname);

    IF @res = 0 THEN
      INSERT INTO webtechtest.users (`loginname`, `firstname`, `lastname`, `registrationDate`, `dateOfBirth`, `statusId`, `permissionId`, `email`, `pincode`)
        VALUES(loginname, firstname,lastname, utc_timestamp(), dateOfBirth, 1, permissionId, email, pincode);
      INSERT INTO webtechtest.wallet (`balance`,`lastupdatedate`,`userid`, `wallettype`)
        VALUES (0,utc_timestamp(),LAST_INSERT_ID(), 1);
      select 0;
    ELSE
        
        select -1;

    END IF;


    END
$$

--
-- Definition for procedure updatePendingGeneratedPayout
--
CREATE 
PROCEDURE updatePendingGeneratedPayout(IN transid INT, IN amount DOUBLE)
BEGIN

IF (transid > 0 and IsNumeric(amount) AND (SELECT count(*) from transaction t where t.transid = transid > 0)) THEN

  SET @wid = (SELECT t.walletId FROM transaction t WHERE t.transId = transid);
  UPDATE wallet SET balance = balance + amount, lastUpdateDate = utc_timestamp() WHERE walletid = @wid;
  UPDATE transaction t SET t.isCommited = 1, t.amount = amount WHERE t.transid = transid;
  SELECT 0;
ELSE
  SELECT -1;
END IF;

END
$$

--
-- Definition for procedure updateUserLock
--
CREATE 
PROCEDURE updateUserLock(IN loginname VARCHAR(20), IN lockComment VARCHAR(225))
BEGIN
  IF (SELECT count(*) FROM users u WHERE u.loginname= loginname AND u.statusId in (1,2) ) > 0 THEN 
    SET @lock = (SELECT u.statusId FROM users u WHERE u.loginname= loginname AND u.statusId in (1,2));
    CASE @lock
      WHEN 1 THEN
        UPDATE users u SET u.statusId = 2, u.statusChangeDate = utc_timestamp, u.statusChangeComment = lockComment WHERE u.loginname = loginname;
      WHEN 2 THEN
        UPDATE users u SET u.statusId = 1, u.statusChangeDate = utc_timestamp, u.statusChangeComment = lockComment WHERE u.loginname = loginname;

    END CASE;   
    SELECT 0;
  ELSE
    SELECT -1;
  END IF;


END
$$

--
-- Definition for procedure updateWorkingHours
--
CREATE 
PROCEDURE updateWorkingHours(IN recId INT(10), IN startHour DATETIME, IN endHour DATETIME, IN description VARCHAR (100))
BEGIN

SET @wid = (SELECT walletId FROM recurringtransaction WHERE recTrans = recId );

IF (@wid > 0 AND startHour < endHour )THEN
  INSERT INTO jobhours(`startHour`,`endHour`,`recId`,`walletId`,`description`, `isCalculated`)
    VALUES  (startHour, endHour, recId, @wid, description, 0);
  SELECT 0;

ELSE

  SELECT "one of the input arguments is incorrect";
END IF;




END
$$

--
-- Definition for function calcSalaryHourWage
--
CREATE 
FUNCTION calcSalaryHourWage(startHour DATETIME, endHour DATETIME, wage DOUBLE)
  RETURNS double
BEGIN
  SET @timeDiff = (SELECT TIMESTAMPDIFF(minute,startHour,endHour));
  SET @minuteWage = wage/60;
  return @timeDiff * @minuteWage;

END
$$

--
-- Definition for function getFutureTrans
--
CREATE 
FUNCTION getFutureTrans(transDate DATE, recurrence INT)
  RETURNS date
BEGIN
    IF (recurrence >= 1 and recurrence < 9 ) then
      SET @futuredate = null;

      CASE recurrence
			    WHEN 10 THEN
				  	SET @futuredate = transDate + INTERVAL 1 day;
  			  WHEN 1 THEN
	  				SET @futuredate = transDate + INTERVAL 1 week;
		  	  WHEN 2 THEN
			  		SET @futuredate = transDate + INTERVAL 2 week;
  			  WHEN 4 THEN
            IF @futuredate = LAST_DAY(transDate) THEN
	  			  	SET @futuredate = LAST_DAY(transDate + INTERVAL 1 month);
            ELSE
            	SET @futuredate = transDate + INTERVAL 1 month;
            END IF;
		  	  WHEN 8 THEN
            IF @futuredate = LAST_DAY(transDate) THEN
	  			  	SET @futuredate = LAST_DAY(transDate + INTERVAL 2 month);
            ELSE
            	SET @futuredate = transDate + INTERVAL 2 month;
            END IF;
        END CASE;
    ELSE
      RETURN '1000-01-01';
    END IF;
RETURN @futuredate;
END
$$

--
-- Definition for function IsNumeric
--
CREATE 
FUNCTION IsNumeric(sIn varchar(1024))
  RETURNS tinyint(4)
RETURN sIn REGEXP '^(-|\\+){0,1}([0-9]+\\.[0-9]*|[0-9]*\\.[0-9]+|[0-9]+)$'
$$

DELIMITER ;



-- 
-- Dumping data for table permission
--
INSERT INTO permission(permissionId, description, name) VALUES 
  (1, 'Regular user', 'Regular'),
  (2, 'Premium user', 'Premium'),
  (3, 'Admin', 'Admin');

-- 
-- Dumping data for table recurrencetype
--
INSERT INTO recurrencetype(recurTypeId, type) VALUES 
  (1, '1 Week'),
  (2, '2 Weeks'),
  (4, '1 Month'),
  (8, '2 Months'),
  (9, 'none'),
  (10, 'Daily');

-- 
-- Dumping data for table transactiontype
--
INSERT INTO transactiontype(typeId, Name, Description) VALUES 
  (1, 'One time income', 'One time income'),
  (2, 'Recurring income', 'Recurring income'),
  (3, 'Recurring Generated income', 'Recurring Generated income'),
  (5, 'One time payout', 'One time payout'),
  (6, 'Recurring payout', 'Recurring payout'),
  (7, 'Recurring Generated payout', 'Recurring Generated payout');

-- 
-- Dumping data for table userstatus
--
INSERT INTO userstatus(statusId, name, description) VALUES 
  (1, 'Open', 'Any new user holds this status until gets loc'),
  (2, 'Locked', 'Locked user'),
  (3, 'Deleted', 'Pending deletion or deleted user');

-- 
-- Dumping data for table wallettype
--
INSERT INTO wallettype(typeId, typeName) VALUES 
  (1, 'Regular'),
  (2, 'Investment');


-- 
-- Enable foreign keys
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;