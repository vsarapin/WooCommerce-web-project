<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'shop');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'qwerty');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '7d>XD&U=AOVnItI):K@<8dF5n8U&n*z>;mPaZjUIhMbtcYf *<||Ti&?6fH^D[~}');
define('SECURE_AUTH_KEY',  'akDOq7<3j0pu^T%)aT!mY!g7LUkn;]qbh8aWk@)OU{UVN(hDz* wi33Er.@UZl)/');
define('LOGGED_IN_KEY',    'l]iLKDot<QlDpKtfM?:/75=f^qIs[-2CP$.uP,{,iCzGs^7N)NsK0G[ktf#D%yhs');
define('NONCE_KEY',        'Y$UC&A~I_2Vt<}FPJ:]/=)Nn>WZ{.Nj3GvN?-M_~g5R#-vict4ASeb)!ZLoWuBR{');
define('AUTH_SALT',        'r@6`%!3BY)J]-nO%.K?<LfsaVUWSiWS`e.s`SB@6>.g9E^A2?yR|N7@7$.NGZ92k');
define('SECURE_AUTH_SALT', '@8~z~4f:4QV(./.~fap!./;}vCck!asY)nIl1x&|,}yTGIyhPzL+A{m?51l7@G)F');
define('LOGGED_IN_SALT',   'N&s<Z6|V{J/g,PWz> YG^^A&!^rHx0$ C8v4xou6cyuzuyYr?Z}APdhK%;Zw<b.`');
define('NONCE_SALT',       'Q,1shJJ1=YLyRZ>]G|o0 yX?xI*Kv(3 .ckL3z>KLo#hyQR0fj.U8xU)t^uS`1i[');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
