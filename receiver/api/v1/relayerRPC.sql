CREATE TABLE relayerRPC (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'autoincremental | 1 unique id for each rpc',
    `endpoint` VARCHAR(128) NOT NULL DEFAULT '' COMMENT 'url for the RPC',
    `calls` INT NULL DEFAULT '0' COMMENT 'how many times we call it',
    `frequency` INT NULL DEFAULT '0' COMMENT 'frequency of call. the higher, less frequently called',
    `order` INT NULL DEFAULT '0' COMMENT 'value to choose who\'s next (adding each time frequency)',
    `miss` INT NULL DEFAULT '0' COMMENT 'statistics for this endpoint',
    `consecutiveMiss` INT NULL DEFAULT '0' COMMENT 'To know if it is not working properly',
    `dateReported` DATE NULL DEFAULT NULL COMMENT 'last time we reported this endpoint is not working'
);