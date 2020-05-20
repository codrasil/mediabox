<?php

namespace Codrasil\Mediabox;

use ArrayAccess;
use DateTime;
use JsonSerializable;
use SplFileInfo;

class File extends SplFileInfo implements ArrayAccess, JsonSerializable
{
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
     * @param  int  $options
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
            Enums\FileKeys::FILESIZE => $filesize = filesize($pathname),
            Enums\FileKeys::SIZE => cm_human_filesize($filesize),
            Enums\FileKeys::MODIFIED => new DateTime(strtotime(filemtime($pathname))),
            Enums\FileKeys::FILEPERMISSIONS => $fileperms = fileperms($pathname),
            Enums\FileKeys::PERMISSION => substr(sprintf("%o", $fileperms), -4),
            Enums\FileKeys::OWNER => posix_getpwuid(fileowner($pathname)),
            Enums\FileKeys::FRAGMENT => $this->fragment(),
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
        return $this->attributes[Enums\FileKeys::FILESIZE];
    }

    /**
     * Retrieve the file size.
     *
     * @return string
     */
    public function size()
    {
        return $this->attributes[Enums\FileKeys::SIZE];
    }

    /**
     * Retrieve the file modified.
     *
     * @return string
     */
    public function modified()
    {
        return $this->attributes[Enums\FileKeys::MODIFIED];
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
     * Preview the file in the browser.
     *
     * @return mixed
     */
    public function fragment()
    {
        if (is_file($this->rootPath.$this->getCurrentPath())) {
            return http_build_query(['f' => $this->getCurrentPath()]);
        }

        return '?'.http_build_query(['p' => $this->getCurrentPath()]);
    }
}
