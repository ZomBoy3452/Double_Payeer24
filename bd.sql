--
-- База данных: `demo41`
--

-- --------------------------------------------------------

--
-- Структура таблицы `batches`
--

CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batchpm` varchar(55) NOT NULL,
  `m_operation_id` varchar(55) NOT NULL,
  `vremya` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `summa` float NOT NULL,
  `segodnya` varchar(12) NOT NULL,
  `frod` int(1) NOT NULL DEFAULT '0',
  `summa_rub` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `deposits`
--

CREATE TABLE IF NOT EXISTS `deposits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `curatorid` int(11) NOT NULL,
  `summa` double(10,2) NOT NULL,
  `unixtime` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `summa` float NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 - нейтрально (отладка), 1 - положительное действие (green), 2 - отрицательное (red)',
  `status` int(1) NOT NULL DEFAULT '0',
  `timeunix` int(22) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ss_users`
--

CREATE TABLE IF NOT EXISTS `ss_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wallet` varchar(15) NOT NULL,
  `curator` int(11) NOT NULL,
  `i_have_refs_as_curator` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL COMMENT 'IP пользователя при регистрации',
  `last_ip` varchar(15) NOT NULL COMMENT 'IP пользователя при последнем входе в аккаунт',
  `came` varchar(50) NOT NULL COMMENT 'Откуда пришел',
  `act_1` int(1) NOT NULL DEFAULT '0',
  `reg_unix` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `came` (`came`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица юзеров' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `userstat`
--

CREATE TABLE IF NOT EXISTS `userstat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` varchar(100) CHARACTER SET utf8 NOT NULL,
  `opisanie` text CHARACTER SET utf8 NOT NULL,
  `color` varchar(50) CHARACTER SET utf8 NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `summa` float DEFAULT NULL,
  `comment` varchar(33) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;