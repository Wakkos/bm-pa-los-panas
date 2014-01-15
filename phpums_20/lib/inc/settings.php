<?php

	/* Constant:	  conn_string;                                                                *\
	 * Description:   Connection string. Uses the format:                                         *
	\*                mysql://username:password@hostname/database                                 */
define("conn_string", "mysql://root:root@localhost:8888/bookmarks");


	/* Constant:	  EMAIL_REGISTRATION;                                                         *\
	 * Description:   If 1 then the use4r must activate the account after registration via a link *
	 *                sent by email. Helpful to check the validity of the email.                  *
	\*                If 0 the user will be automatically logged in after registration.           */
define("EMAIL_REGISTRATION", "0");


	/* Constant:	  site_root;                                                                  *\
	\ * Description:   Main root of the project.                                                   */
define("site_root", "http://localhost/bookmarks");


?>