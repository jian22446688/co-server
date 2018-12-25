--
-- 表的结构 `cmf_plugin_tcuser_coin`
--

CREATE TABLE IF NOT EXISTS `cmf_plugin_tcuser_coin` (
  `coin_ID` int(11) NOT NULL,
  `coin_InviteCode` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '充值卡',
  `coin_Coin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  `coin_user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '使用者用户id',
  `coin_user_IsUsed` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用',
  `coin_Intro` varchar(500) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='金币充值卡';

--
-- Indexes for table `cmf_plugin_tcuser_coin`
--
ALTER TABLE `cmf_plugin_tcuser_coin`
  ADD PRIMARY KEY (`coin_ID`);

--
-- AUTO_INCREMENT for table `cmf_plugin_tcuser_coin`
--
ALTER TABLE `cmf_plugin_tcuser_coin`
  MODIFY `coin_ID` int(11) NOT NULL AUTO_INCREMENT;


--
-- 表的结构 `cmf_plugin_tcuser_buy`
--

CREATE TABLE IF NOT EXISTS `cmf_plugin_tcuser_buy` (
  `buy_ID` int(11) NOT NULL,
  `buy_OrderID` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '订单编号',
  `buy_LogID` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买人',
  `buy_AuthorID` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章发布人',
  `buy_ArticleID` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `buy_PostTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买时间',
  `buy_Pay` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买价格',
  `buy_IP` varchar(15) NOT NULL COMMENT '购买IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='购买记录';

--
-- Indexes for table `cmf_plugin_tcuser_coin`
--
ALTER TABLE `cmf_plugin_tcuser_buy`
  ADD PRIMARY KEY (`buy_ID`);

--
-- AUTO_INCREMENT for table `cmf_plugin_tcuser_coin`
--
ALTER TABLE `cmf_plugin_tcuser_buy`
  MODIFY `buy_ID` int(11) NOT NULL AUTO_INCREMENT;