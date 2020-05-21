<?php

namespace Codrasil\Mediabox\Enums;

abstract class IconKeys
{
    const MDI_JPG = 'mdi mdi-file-image-outline';
    const MDI_JPEG = 'mdi mdi-file-image-outline';
    const MDI_PNG = 'mdi mdi-file-image-outline';
    const MDI_GIF = 'mdi mdi-gif';

    const MDI_ZIP = 'mdi mdi-folder-zip-outline';
    const MDI_7Z = 'mdi mdi-folder-zip-outline';
    const MDI_TAR = 'mdi mdi-folder-zip-outline';
    const MDI_GZ = 'mdi mdi-folder-zip-outline';
    const MDI_RAR = 'mdi mdi-folder-zip-outline';
    const MDI_PKG = 'mdi mdi-folder-zip-outline';
    const MDI_BZ2 = 'mdi mdi-folder-zip-outline';
    const MDI_DEB = 'mdi mdi-debian';

    const MDI_ANDROID = 'mdi mdi-android';
    const MDI_APK = 'mdi mdi-android';
    const MDI_APPLE = 'mdi mdi-apple';
    const MDI_DMG = 'mdi mdi-apple';

    const MDI_SQL = 'mdi mdi-database';
    const MDI_SQL3 = 'mdi mdi-database';
    const MDI_SQLITE = 'mdi mdi-database';
    const MDI_DB = 'mdi mdi-database';
    const MDI_INDEX = 'mdi mdi-database';
    const MDI_KEY = 'mdi mdi-key-outline';

    const MDI_ISO = 'mdi mdi-disc';

    const MDI_PDF = 'mdi mdi-file-pdf-outline';

    const MDI_FILE = 'mdi mdi-file-outline';
    const MDI_TXT = 'mdi mdi-note-text-outline';
    const MDI_MD = 'mdi mdi-language-markdown-outline';
    const MDI_TASK = 'mdi mdi-text-box-check-outline';
    const MDI_TASKS = 'mdi mdi-text-box-check-outline';
    const MDI_TODO = 'mdi mdi-text-box-check-outline';
    const MDI_CSV = 'mdi mdi-file-delimited-outline';
    const MDI_URL = 'mdi mdi-web';
    const MDI_PART = 'mdi mdi-file-download-outline';

    const MDI_PEM = 'mdi mdi-certificate-outline';

    const MDI_MUSIC = 'mdi mdi-music';
    const MDI_MP3 = 'mdi mdi-music';
    const MDI_WAV = 'mdi mdi-music';

    const MDI_SRT = 'mdi mdi-subtitles-outline';

    const MDI_VIDEO = 'mdi mdi-video-vintage';
    const MDI_MP4 = 'mdi mdi-video-vintage';
    const MDI_MKV = 'mdi mdi-video-vintage';
    const MDI_AVI = 'mdi mdi-video-vintage';
    const MDI_MOV = 'mdi mdi-video-vintage';
    const MDI_WEBM = 'mdi mdi-video-vintage';
    const MDI_MPEG = 'mdi mdi-video-vintage';
    const MDI_MPG = 'mdi mdi-video-vintage';
    const MDI_OGG = 'mdi mdi-video-vintage';
    const MDI_WMV = 'mdi mdi-video-vintage';

    const MDI_CSS = 'mdi mdi-language-css3';
    const MDI_HTM = 'mdi mdi-language-html5';
    const MDI_HTML = 'mdi mdi-language-html5';
    const MDI_JS = 'mdi mdi-language-javascript';
    const MDI_PHP = 'mdi mdi-language-php';
    const MDI_SASS = 'mdi mdi-sass';
    const MDI_STYL = 'mdi mdi-language-css3 mdi-styl';
    const MDI_TS = 'mdi mdi-language-typescript';
    const MDI_SCSS = 'mdi mdi-sass';
    const MDI_VUE = 'mdi mdi-vuejs';
    const MDI_JSON = 'mdi mdi-code-json';
    const MDI_LOCK = 'mdi mdi-lock';
    const MDI_XML = 'mdi mdi-xml';
    const MDI_ENV = 'mdi mdi-file-settings-outline';

    const MDI_GITIGNORE = 'mdi mdi-git';
    const MDI_GITATTRIBUTES = 'mdi mdi-git';
    const MDI_KEEP = 'mdi mdi-pin';

    const MDI_XLSX = 'mdi mdi-microsoft-excel';
    const MDI_XLS = 'mdi mdi-microsoft-excel';
    const MDI_DOCX = 'mdi mdi-microsoft-word';
    const MDI_DOC = 'mdi mdi-microsoft-word';
    const MDI_PPTX = 'mdi mdi-microsoft-powerpoint';
    const MDI_PPT = 'mdi mdi-microsoft-powerpoint';

    const MDI_ODT = 'mdi mdi-file-document';
    const MDI_ODS = 'mdi mdi-google-spreadsheet';

    const MDI_EXE = 'mdi mdi-microsoft-windows';
    const MDI_MSI = 'mdi mdi-microsoft-windows';

    const MDI_BASH = 'mdi mdi-bash';
    const MDI_BASHRC = 'mdi mdi-bash';
    const MDI_BASH_HISTORY = 'mdi mdi-bash';
    const MDI_BASH_LOGOUT = 'mdi mdi-bash';

    const MDI_OTF = 'mdi mdi-format-font';
    const MDI_TTF = 'mdi mdi-format-font';
    const MDI_WOFF = 'mdi mdi-format-font';
    const MDI_WOFF2 = 'mdi mdi-format-font';

    /**
     * Try to guess the icon class for a given extension.
     *
     * @param  string $extension
     * @return string
     */
    public static function guess($extension)
    {
        $mdi = self::MDI_FILE;

        if (defined('self::MDI_'.strtoupper($extension))) {
            $mdi = constant('self::MDI_'.strtoupper($extension));
        }

        return "icon-$extension $mdi";
    }
}
