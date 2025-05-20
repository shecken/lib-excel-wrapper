<?php

declare(strict_types=1);

namespace CaT\Libs\ExcelWrapper;

class Style {
	const ORIENTATION_LEFT = "left";
	const ORIENTATION_RIGHT = "right";
	const ORIENTATION_CENTER = "center";
	const ORIENTATION_BLOCK = "block";

	const COLOR_REG_EXP = "/^[A-Fa-f0-9]{6}$/i";

	public function __construct(
        protected string $font_family = "Arial",
		protected int    $font_size = 10,
		protected bool   $bold = false,
		protected bool   $italic = false,
        protected bool   $underlined = false,
        protected string $text_color = "000000",
        protected string $background_color = "ffffff",
        protected bool   $vertical_line = false,
        protected string $orientation = self::ORIENTATION_LEFT
	) {
        if (!$this->validateOrientation($orientation)) {
            throw new \InvalidArgumentException("Orientation '{$orientation}' is not valid");
        }

        if (!$this->validateColor($background_color)) {
            throw new \InvalidArgumentException("Background color '{$background_color}' is not valid");
        }

        if (!$this->validateColor($text_color)) {
            throw new \InvalidArgumentException("Text color '{$text_color}' is not valid");
        }

        if($font_size <= 0) {
            throw new \InvalidArgumentException("Font size must be greater than 0");
        }

        if ($font_family === "") {
            throw new \InvalidArgumentException("Font family cannot be empty");
        }
    }

	public function getFontFamily(): string
    {
		return $this->font_family;
	}

	public function getFontSize(): int
    {
		return $this->font_size;
	}

	public function getBold(): bool
    {
		return $this->bold;
	}

	public function getItalic(): bool
    {
		return $this->italic;
	}

	public function getUnderline(): bool
    {
		return $this->underlined;
	}

	public function getTextColor(): string
    {
		return $this->text_color;
	}

	public function getBackgroundColor(): string
    {
		return $this->background_color;
	}

	public function getVerticalLine(): bool
    {
		return $this->vertical_line;
	}

	public function getOrientation(): string
    {
		return $this->orientation;
	}

	public function withFontFamily(string $font_family): self
    {
		if ($font_family === "") {
            throw new \InvalidArgumentException("Font family cannot be empty");
        }

		$clone = clone $this;
		$clone->font_family = $font_family;
		return $clone;
	}

	public function withFontSize(int $font_size): self
    {
        if($font_size <= 0) {
            throw new \InvalidArgumentException("Font size must be greater than 0");
        }

		$clone = clone $this;
		$clone->font_size = $font_size;
		return $clone;
	}

	public function withBold(bool $bold): self
    {
		$clone = clone $this;
		$clone->bold = $bold;
		return $clone;
	}

	public function withItalic(bool $italic): self
    {
		$clone = clone $this;
		$clone->italic = $italic;
		return $clone;
	}

	public function withUnderline(bool $underline): self
    {
		$clone = clone $this;
		$clone->underlined = $underline;
		return $clone;
	}

	public function withTextColor(string $text_color): self
    {
        if (!$this->validateColor($text_color)) {
            throw new \InvalidArgumentException("Text color '{$text_color}' is not valid");
        }

		$clone = clone $this;
		$clone->text_color = $text_color;
		return $clone;
	}

	public function withBackgroundColor(string $background_color): self
    {
        if (!$this->validateColor($background_color)) {
            throw new \InvalidArgumentException("Background color '{$background_color}' is not valid");
        }

		$clone = clone $this;
		$clone->background_color = $background_color;
		return $clone;
	}

	public function withVerticalLine(bool $vertical_line): self
    {
		$clone = clone $this;
		$clone->vertical_line = $vertical_line;
		return $clone;
	}

	public function withOrientation(string $orientation): self
    {
		if (!$this->validateOrientation($orientation)) {
            throw new \InvalidArgumentException("Orientation '{$orientation}' is not valid");
        }

		$clone = clone $this;
		$clone->orientation = $orientation;
		return $clone;
	}

	protected function validateColor(string $color_code): bool
    {
		return (bool)preg_match(self::COLOR_REG_EXP, $color_code);
	}

	protected function validateOrientation(string $orientation): bool
    {
		return in_array(
            $orientation,
            array(
                self::ORIENTATION_LEFT,
                self::ORIENTATION_RIGHT,
                self::ORIENTATION_CENTER,
                self::ORIENTATION_BLOCK
            )
        );
	}
}