<?php

namespace Codrasil\Mediabox\Concerns;

trait CanGenerateThumbnail
{
    /**
     * The thumbnail width.
     *
     * @var integer
     */
    protected $thumbnailWidth = 25;

    /**
     * The thumbnail height.
     *
     * @var integer
     */
    protected $thumbnailHeight = 25;

    /**
     * Check if file has thumbnail.
     *
     * @return boolean
     */
    public function hasThumbnail()
    {
        return $this->isImage();
    }

    /**
     * Retrieve the thumbnail if file is image.
     *
     * @return mixed
     */
    public function thumbnail()
    {
        try {
            if ($this->exists() && $this->isImage()) {
                $imagick = new \Imagick($this->getRealPath());
                $imagick->thumbnailImage(
                    $this->getThumbnailWidth(),
                    $this->getThumbnailHeight(),
                    $bestFit = false, $fill = true
                );
                $hash = base64_encode($imagick->getImageBlob());

                return 'data:image/jpg;base64,'.$hash;
            }
        } catch (\Exception $e) {
            unset($e);

            return false;
        }
    }

    /**
     * Set the thumbnail width.
     *
     * @param  integer $width
     * @return integer
     */
    public function setThumbnailWidth($width)
    {
        return $this->thumbnailWidth = $width;
    }

    /**
     * Set the thumbnail width.
     *
     * @param  integer $height
     * @return integer
     */
    public function setThumbnailHeight($height)
    {
        return $this->thumbnailHeight = $height;
    }

    /**
     * Retrieve the thumbnail width.
     *
     * @return integer
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnailWidth;
    }

    /**
     * Retrieve the thumbnail width.
     *
     * @return integer
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnailHeight;
    }
}
