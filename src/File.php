<?php

namespace Codrasil\Mediabox;

use ArrayAccess;
use Carbon\Carbon;
use Codrasil\Mediabox\Enums\IconKeys;
use DateTime;
use JsonSerializable;
use SplFileInfo;

class File extends SplFileInfo implements ArrayAccess, JsonSerializable
{
    use Concerns\CanGenerateThumbnail;

    /**
     * The file attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * The file root path.
     *
     * @var array
     */
    protected $rootPath;

    /**
     * The constructor class.
     *
     * @param string $path
     * @param string $rootPath
     */
    public function __construct($path, $rootPath)
    {
        parent::__construct($path);

        $this->rootPath = $rootPath;

        $this->attributes = $this->prepareAttributes(
            pathinfo($path)
        );
    }

    /**
     * Retrieve the current path.
     *
     * @return string
     */
    public function getCurrentPath()
    {
        return str_replace($this->rootPath, '', $this->getRealpath());
    }

    /**
     * Retrieve the root path.
     *
     * @return string
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }

    /**
     * Check if file exists.
     *
     * @return boolean
     */
    public function exists(): bool
    {
        return file_exists($this->getPathname());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    /**
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->attributes[$offset])
             ? $this->attributes[$offset]
             : null;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  integer $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return parent::__toString();
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true);
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
        }, $this->attributes);
    }

    /**
     * Add keys to the array.
     *
     * @param  array $attributes
     * @return array
     */
    protected function prepareAttributes($attributes)
    {
        if (! $this->exists()) {
            return $attributes;
        }

        return array_merge($attributes, [
            Enums\FileKeys::ACCESSED => new DateTime(strtotime($this->getATime())),
            Enums\FileKeys::CHANGED => new DateTime(strtotime($this->getCTime())),
            Enums\FileKeys::NAME => $this->name(),
            Enums\FileKeys::FILENAME => $this->filename(),
            Enums\FileKeys::PATHNAME => $pathname = $this->getPathname(),
            Enums\FileKeys::TYPE => $this->getType(),
            Enums\FileKeys::FILESIZE => $filesize = $this->filesize(),
            Enums\FileKeys::SIZE => $this->size(),
            Enums\FileKeys::MODIFIED_AT => $this->modified(),
            Enums\FileKeys::MODIFIED => $this->modified()->diffForHumans(),
            Enums\FileKeys::UPDATED_AT => $this->modified()->format('Y-m-d H:i:s'),
            Enums\FileKeys::FILEPERMISSIONS => $fileperms = fileperms($pathname),
            Enums\FileKeys::PERMISSION => substr(sprintf("%o", $fileperms), -4),
            Enums\FileKeys::OWNER => posix_getpwuid(fileowner($pathname)),
            Enums\FileKeys::FRAGMENT => $this->fragment(),
            Enums\FileKeys::MIMETYPE => $this->mimetype(),
            Enums\FileKeys::ICON => $this->icon(),
            Enums\FileKeys::COUNT => $this->count(),
            Enums\FileKeys::DIRNAME => $this->dirname(),
            Enums\FileKeys::IS_FILE => $this->getType() == Enums\FileKeys::FILE_KEY,
            Enums\FileKeys::IS_DIR => $this->getType() == Enums\FileKeys::DIR_KEY,
        ]);
    }

    /**
     * Retrieve the file accessed.
     *
     * @return string
     */
    public function accessed()
    {
        return $this->attributes[Enums\FileKeys::ACCESSED];
    }

    /**
     * Retrieve the file changed.
     *
     * @return string
     */
    public function changed()
    {
        return $this->attributes[Enums\FileKeys::CHANGED];
    }

    /**
     * Retrieve the file pathname.
     *
     * @return string
     */
    public function pathname()
    {
        return $this->attributes[Enums\FileKeys::PATHNAME];
    }

    /**
     * Retrieve the file pathname.
     *
     * @return string
     */
    public function name()
    {
        return basename($this->getPathname());
    }

    /**
     * Retrieve the file pathname.
     *
     * @return string
     */
    public function filename()
    {
        return ltrim($this->getCurrentPath(), '/');
    }

    /**
     * Retrieve the file type.
     *
     * @return string
     */
    public function type()
    {
        return $this->attributes[Enums\FileKeys::TYPE];
    }

    /**
     * Retrieve the file filesize.
     *
     * @return string
     */
    public function filesize()
    {
        return filesize($this->getRealpath());
    }

    /**
     * Retrieve the file size.
     *
     * @return string
     */
    public function size()
    {
        return cm_human_filesize($this->filesize());
    }

    /**
     * Retrieve the file modified.
     *
     * @return string
     */
    public function modified()
    {
        return Carbon::parse(date('Y-m-d H:i:s', filemtime($this->getRealPath())));
    }

    /**
     * Retrieve the file permission.
     *
     * @return string
     */
    public function permission()
    {
        return $this->attributes[Enums\FileKeys::PERMISSION];
    }

    /**
     * Retrieve the file owner.
     *
     * @return string
     */
    public function owner()
    {
        return $this->attributes[Enums\FileKeys::OWNER];
    }

    /**
     * Retrieve the file owner.
     *
     * @return string
     */
    public function ownername()
    {
        return $this->attributes[Enums\FileKeys::OWNER]['name'] ?? null;
    }

    /**
     * Retrieve the directory of the current file.
     *
     * @return string
     */
    public function dirname()
    {
        $dirname = dirname($this->getRealPath());

        return str_replace($this->rootPath, '', $dirname);
    }

    /**
     * Preview the file in the browser.
     *
     * @return mixed
     */
    public function fragment()
    {
        if (is_file($this->rootPath.$this->getCurrentPath())) {
            return http_build_query(array_merge($_GET, ['f' => $this->getCurrentPath()]));
        }

        return '?'.http_build_query(array_merge($_GET, ['p' => $this->getCurrentPath()]));
    }

    /**
     * Retrieve the file accessed.
     *
     * @return string
     */
    public function mimetype()
    {
        return mime_content_type($this->getRealpath());
    }

    /**
     * Retrieve the copy name of the file.
     * e.g. Copy of file.txt
     *
     * @param  string      $prefix
     * @param  string|null $suffix
     * @return string
     */
    public function getCopyName($prefix = 'Copy of ', $suffix = null)
    {
        $dir = dirname($this->filename()).DIRECTORY_SEPARATOR;
        $name = pathinfo($this->filename(), PATHINFO_FILENAME);

        $extension = $this->getExtension() ? '.'.$this->getExtension() : null;

        return $dir.$prefix.$name.$suffix.$extension;
    }

    /**
     * Retrieve the icon for the file.
     * Uses an Enum class of icon classes.
     *
     * @return IconKeys
     */
    public function icon()
    {
        return IconKeys::guess($this->isDir() ? 'folder_'.$this->name() : $this->getExtension());
    }

    /**
     * Retrieve the exif data of the image file.
     *
     * @return array
     */
    public function exif()
    {
        if ($this->isFile() && exif_imagetype($this->getRealPath())) {
            return exif_read_data($this->getRealPath(), 'IFD0');
        }

        return [];
    }

    /**
     * Check if file is an image.
     *
     * @return boolean
     */
    public function isImage()
    {
        // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged
        return @exif_imagetype($this->getRealPath()) !== false;
    }

    /**
     * Retrieve the number of items inside the folder.
     *
     * @return mixed
     */
    public function count()
    {
        if ($this->isFile()) {
            return;
        }

        return count(glob($this->getRealpath().DIRECTORY_SEPARATOR.'*'));
    }
}
