-- MySQL dump 10.13  Distrib 5.7.33, for Linux (x86_64)
--
-- Host: localhost    Database: songbook_database
-- ------------------------------------------------------
-- Server version	5.7.33-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `songbook_database`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `songbook_database` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `songbook_database`;

--
-- Table structure for table `book_table`
--

DROP TABLE IF EXISTS `book_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `songids` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_table`
--

LOCK TABLES `book_table` WRITE;
/*!40000 ALTER TABLE `book_table` DISABLE KEYS */;
INSERT INTO `book_table` VALUES (1,'Test book','7,2,pb,8','{\"FONT_STYLE\":\"times\",\"FONT_SIZE\":\"8\",\"CHORD_SIZE\":\"7\",\"SONGNUM_SIZE\":\"10.5\",\"DOUBLE_COL\":false,\"INDEX\":true,\"SOURCE\":{}}'),(3,'Atestbook','',''),(4,'Hall 1 HS 2021','10,8,9','{\"FONT_STYLE\":\"times\",\"FONT_SIZE\":\"8\",\"CHORD_SIZE\":\"8\",\"SONGNUM_SIZE\":\"14\",\"DOUBLE_COL\":true,\"INDEX\":true,\"SOURCE\":{}}');
/*!40000 ALTER TABLE `book_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song_table`
--

DROP TABLE IF EXISTS `song_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `song_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `source` text NOT NULL,
  `lyrics` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_table`
--

LOCK TABLES `song_table` WRITE;
/*!40000 ALTER TABLE `song_table` DISABLE KEYS */;
INSERT INTO `song_table` VALUES (2,'Fill my cup, Lord','','','{chorus}\r\nFill my [G]cup, Lord;\r\nI lift it [D]up, Lord;\r\nCome and q[D7]uench\r\nThis thirsting of my[G] soul.\r\n[]Bread of Heaven,\r\n[G7]Feed me till I [C]want no [Am]more.\r\nFill my [D]cup, fill it [D7]up\r\nAnd make me [G]whole.\r\n\r\n{verse: 1}\r\nLike the woman at the well, I was s[D]eeking\r\nFor [D7]things that could not sati[G]sfy.\r\nAnd then I [G7]heard my Savior s[C]peaking[Am]-\r\n\"Draw from My [D]well\r\nThat [D7]never shall run [G]dry.\"\r\n\r\n{verse: 2}\r\nThere are millions in this world\r\nwho are seeking\r\nFor pleasures earthly goods afford.\r\nBut none can match the wondrous treasure\r\nThat I find in Jesus Christ my Lord.\r\n\r\n{verse: 3}\r\nSo my brother, if the things that this\r\nworld gives you\r\nLeave hungers that won\'t pass away,\r\nMy blessed Lord will come and save you\r\nIf you kneel to Him and humbly pray-'),(6,'Astro del ciel','','','{t:Astro del ciel}\r\n{tag: Natale}\r\n\r\n{Key:G}\r\n[G]Astro del ciel, Pargol divin\r\n[D]mite Ag[D7]nello [G]Reden[G7]tor.\r\n[C]Tu che i [Am7]vati da [G]lungi sog[Em7]nar\r\n[Am7]tu che an[C]geliche [G]voci annunzi[Bm7]ar.\r\n[D]Luce [Am7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor,[G7]\r\n[Am7]Luce [D7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor.\r\n\r\n[G]Astro del ciel, pargol Divin\r\n[D]mite Ag[D7]nello [G]Reden[G7]tor.\r\n[C]Tu di s[Am7]tirpe re[G]gale de[Em7]cor,\r\n[Am7]Tu vir[C]gineo [G]mistico fi[Bm7]or.\r\n[D]Luce [Am7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor,[G7]\r\n[Am7]Luce [D7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor.\r\n\r\n[G]Astro del ciel, pargol Divin\r\n[D]mite Ag[D7]nello [G]Reden[G7]tor.\r\n[C]Tu di[Am7]sceso a scon[G]tare l\'err[Em7]or,\r\n[Am7]Tu sol [C]nato a par[G]lare d\'a[Bm7]mor.\r\n[D]Luce [Am7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor,[G7]\r\n[Am7]Luce [D7]dona alle [Em7]men[C7+]ti, [G]pace in[D7]fondi nei c[G]uor.'),(7,'Jesus Beloved, You are the Prize','','','[D]Jesus [A]Beloved, [Em]You are the [A]Prize!\r\n[D]You are my [G]treasure and\r\nWith [D]whom [A]my heart [D]lies.\r\nJesus Bel[A]oved, with[Em]in me You[A] dwell;\r\n[D]We are [G]woven together and [D]in[A]separa[D]ble!\r\nJesus Bel[G]oved, I sur[D]render my [A]being;\r\nTrans[D]form every [G]part\r\nAnd [D]fill me com[A]pletely,\r\n[D]Jesus [G]Beloved, with Your[F#m] nature\r\nSo [Bm]glorious.\r\n[D]How could I [G]not love someo[D]ne\r\nSo [A]marvell[D]ous!'),(8,'Lamb of God - our dear Redeeming One','','','{verse: 1 }\r\n[C]Lamb of God-our dear Re[G]deeming One is Christ!\r\nFor our [Am]sins He paid the [Em]highest price\r\nTo re[F]deem and to [C]recover us\r\nWho were [Dm]lost and fallen far from [G]God.\r\nAs the [C]Lamb, He had no [G]blemish;\r\nHe was [Am]meek, even sub[Em]missive.\r\nHow can [F]we like Him o[C]bedient be\r\nUnto [Dm]death, that [G]even of the [C]cross?\r\n\r\n {chorus}\r\n[C]I want to [F]follow Him, [G] \r\nRest from all my [Em]wandering, [A7]\r\nEnd all my en[Dm]deavoring; [G]\r\nEven though I [C]know not where or\r\n[Gm]How-I [C7]know He [F]cares!\r\nI know He’ll [G]never err;\r\nI [E]know He’ll lead me [Am]well.\r\nI know His [F]voice; this now my [G]choice-\r\nFollow where the [C]Lamb would lead.\r\n\r\n{verse: 2 }\r\nWhen He came, though many followed in the way,\r\nFew remained who knew Him and His ways.\r\nLamb of God-He took  the narrow gate;\r\nThe constricted way to life He traced;\r\nSacrificed, though men denied Him;\r\nGave His life, though men forsook Him.\r\nHow can we t’ward Him still hardened be\r\nWhen to us He gave all selflessly?\r\n\r\n{verse: 3 }\r\nLord we pray, preserve us faithful in the way\r\nAll our days, never to fall away.\r\nBy Your grace, keep us pursuing You,\r\nTaking up the cross to follow You.\r\nConsecrate we unreservedly,\r\nAbsolute for You entirely.\r\nIn our hearts, Lord, let the highways be\r\nUnto Zion single-heartedly.\r\n\r\n {chorus}\r\nNow we will follow Him!\r\nTo His call we’re answering,\r\nAll we are we’re offering.\r\nNew Jerusalem we see\r\nCome down from heav’n to earth!\r\nGod and man mingled now,\r\nOur oneness we avow\r\nEternally, O gloriously!\r\nThis is where the Lamb would lead!'),(9,'We are the church—Ekklesia','','BSB #429','{verse: 1}\r\n[E]We are the [B]church-Ekkl[C#m]esia [A]\r\n[E]Called out from the w[B]orld,\r\n[C#m]Separated unto [A]God.\r\n\r\n{chorus}\r\n[E]O Lord, [B]keep us in Your [C#m]Word,\r\n[A]sanctify us.\r\n[E]Lord Jesus [B]build up Your [A]churc[E]h.\r\n\r\n{verse: 2}\r\nWe are the bride, His counterpart.\r\nHe attracted us,\r\nNow we love nothing else.\r\n\r\n{verse: 3}\r\nWe are a poem, God’s masterpiece\r\nAn expression of Him,\r\nA testimony of His love.\r\n\r\n{verse: 4}\r\nWe are one Body, one entity.\r\nConnected to the Head\r\nTo receive all that He is.\r\n\r\n{verse: 5}\r\nWe are the Lord’s recovery;\r\nPhiladelphia;\r\nHolding fast in purity.'),(10,'As the hart panteth for the water','','BSB #344','{comment:  Psa. 42:1-2; 28:7}\r\n\r\n[C]As the [G]hart panteth [Am]for the [Dm]water,\r\nSo my [F]soul longeth [G]after [C]Thee[G].\r\n[C]You a[G]lone are my [Am]heart’s [Dm]desire\r\nAnd I [F]long to [G]worship [C]Thee[G].\r\n\r\n{chorus}\r\n[Am]You alone are my [F]Strength, my [C]Shield,\r\nTo [F]You alone may my [Dm]spirit [E]yield.\r\n[C]You al[G]one are my [Am]heart’s [Dm]desire\r\nAnd I [F]long to [G]worship [C]Thee.\r\n\r\nYou’re my Friend, and You are my Brother,\r\nEven though You are a King.\r\nI love You more than any other,\r\nSo much more than anything.\r\n\r\nI want You more than Gold or Silver\r\nOnly You can satisfy\r\nYou alone are the real joy giver\r\nAnd the apple of my eye'),(11,'After breakfast on the seashore','','','{verse: 1}\r\n[C]After breakfast [G]on the [C]seashore,\r\nJesus [F]set ab[C]out to [G]restore\r\nPeter\'s [F]love, that [C]he would [G]henceforth\r\n[]Not trust himself,\r\n[C]He committed [G]some big [C]failures,\r\nThree times [F]deny[C]ing the [G]Savior,\r\nThen lead[F]ing oth[C]ers to [G]waiver,\r\n[]Yet Jesus said...\r\n\r\n{chorus}\r\nDo you [Am]love Me? [F]Feed My [C]lam[G]bs,\r\nDo you [Am]love Me? [F]Shepherd [C]My she[G]ep,\r\n[F]Do [E7]you [Am]love [F]Me?\r\nThen [C]give My [G]sheep something to [F]ea[C]t.\r\n\r\n{verse: 2}\r\nWe, like Peter, all have stumbled,\r\nSuch defeats make our strength crumble,\r\nOur once proud hearts become humble,\r\nWe are so low,\r\nIn these moments the Lord comes in,\r\nSeeking our love and affection,\r\nAs we listen, we can hear Him\r\nSaying to us...\r\n\r\n{verse: 3}\r\nIn these days the Lord is hindered\r\nBecause of a lack of shepherds\r\nWho dispense the milk of the Word\r\nTo the lost sheep,\r\nHe needs man’s cooperation,\r\nTo let Him shepherd from within,\r\nWill you be one who is open\r\nAnd say to Him...\r\n\r\n{chorus}\r\nLord, I love You! I\'ll feed Your lambs,\r\nLord I love You! I\'ll shepherd Your sheep,\r\nLord I love You!\r\nI\'ll give Your sheep something to eat.'),(12,'Obscenity is favourable away essentially an internet search away','MilanGok','','Few things are sincerely universal. But while people across the time address contrasting languages, put manifold foods and stable be sorry for distinct emotions, millions across the people note porn. In the face being so generally consumed, porn is maligned as the creator of friendship’s ills. It’s constant been labelled a mr condition gamble past politicians in Utah. \r\n \r\nPorn has transformed over the late few decades, due to the availability of the internet and faster net connections. It is also becoming more immersive than a day before. Take understood reality. Earlier this year, researchers from Newcastle University in the UK keen out that VR changes the acquaintance of porn from detached beholder to protagonist. They warned that this has the potential to hide the line between authenticity and pipedream, perhaps damaging relationships and encouraging unhealthy behaviour. \r\n \r\nBut what does the corroboration as a matter of fact reveal about how porn may or may not be affecting people? Can inquire into provide any answers? The actuality is that it is a difficult theme proper for scientists to study. The simplicity of porn dictates that researchers must either rely on people self-reporting their porn habits, or show it to them in laboratory settings that are unnatural. (And no mistrust, shed weight trying, too.) \r\n \r\nThat said, there is a growing fuselage of handbills that can purvey hints. BBC Tomorrow reviewed what researchers keep concluded so far. \r\n \r\nmore on - gay0day</a>\r\n');
/*!40000 ALTER TABLE `song_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-07 11:49:05
