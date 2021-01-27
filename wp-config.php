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
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'asq' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'asq' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'asq' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hsh&z2GW,fP#WzMla~q[A;/dNi9-]=ro4]W?^TcOOlIcF-itqEDizR@z|t6]3oxd' );
define( 'SECURE_AUTH_KEY',  'CP:cM<;lP,a~M0gx=4!YF2FyhaAo^|JzrdXuX,SS6xH%Hh^ tdId_r/}w~Zn*4?W' );
define( 'LOGGED_IN_KEY',    'YQ+#R|PBVwvN[OTs*iBxH>pp Ld+Z+LXigT(CGu+#mJ*QoT:ee4H^@(yeFum:Jo<' );
define( 'NONCE_KEY',        'C2{GojW)nYRlrJ79K913ncSo8tiMSVr)qrLg)>+)=I{GV-(5Bkt6G{X(t7hO5XR%' );
define( 'AUTH_SALT',        '{KHg0Dee{La!dRn h;^.wCLw~4lK3`i7`8GHn]kJfUs#@7SET6<sU=fA`^u|W`[o' );
define( 'SECURE_AUTH_SALT', '~n#katufY+Fr?{{u-^R.H1$T]xU8dK_0hU` kkm_7w}Sg=Jx,4|3E{5mA+A%1@y(' );
define( 'LOGGED_IN_SALT',   '5IWCzk!&cT|$q2b}noG_P?,5~u);v5]Z}ds`~o h*d]uw_CivD(fuR@quCKr-W##' );
define( 'NONCE_SALT',       '8Qs9~62QLaD%p2]1,%MP:Ub%skA>tWtqgPSW0S: `AX7X|zrq*^!JS=$|JzF7q=J' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wpasq_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
