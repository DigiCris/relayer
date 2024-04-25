CREATE TABLE requestLogs (`id` INT() NOT NULL AUTO_INCREMENT DEFAULT '' COMMENT 'autoincremental | 1 unique id for each request', `request` VARCHAR(1024) NULL DEFAULT '0x0' COMMENT 'request and signature to relay', `txHash` VARCHAR(128) NULL DEFAULT '0x0' COMMENT 'Hash of the transaction', `status` VARCHAR(32) NULL DEFAULT 'pending' COMMENT 'error:code / pending/ success / canceled', `timestamp` DATE() NULL DEFAULT '' COMMENT 'when was tx sent', `from` VARCHAR(42) NULL DEFAULT '0x0' COMMENT 'who signed the tx', `nonce` INT() NULL DEFAULT '' COMMENT 'nonce to keep track of execution', `emailSent` INT() NULL DEFAULT '' COMMENT 'error informed or not?', `retry` INT() NULL DEFAULT '0' COMMENT 'How many reties to send to rpc')