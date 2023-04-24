<?php

namespace Quepenny\Livewire\Http\Livewire\Modal;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use LivewireUI\Modal\ModalComponent;
use Quepenny\Livewire\Http\Livewire\Modal\Contracts\CustomActions;
use Quepenny\Livewire\Traits\Livewire\Toastable;
use Quepenny\Livewire\Traits\Livewire\ValidatesInput;

/**
 * docs: https://github.com/wire-elements/modal
 *
 * @property-read string $title
 * @property-read string $subtitle
 * @property-read string $confirmText
 * @property-read string $cancelText
 * @property-read View|string $body
 */
abstract class BaseModalComponent extends ModalComponent
{
    use Toastable;
    use ValidatesInput;

    public static string $slug = '';

    public ?string $transSlug = null;

    public bool $destructiveAction = false;

    public bool $showConfirmButton = true;

    protected static bool $closeModalOnEscape = true;

    protected static bool $closeModalOnClickAway = true;

    protected array $customActions = [];

    public function booted(): void
    {
        $this instanceof CustomActions && $this->registerCustomActions();
    }

    public function getTitleProperty(): string
    {
        return $this->trans('title') ?? Str::title(Str::snake(class_basename($this), ' '));
    }

    public function getSubtitleProperty(): ?string
    {
        return $this->trans('subtitle');
    }

    public function getBodyProperty(): string|View
    {
        return $this->trans('body');
    }

    public function getConfirmTextProperty(): string
    {
        return $this->trans('confirm') ?? 'Okay';
    }

    final public function getCancelTextProperty(): string
    {
        return $this->trans('cancel') ?? 'Cancel';
    }

    public function confirm()
    {
        $this->closeModal();
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function executeAction(string $action)
    {
        $this->customActions[$action]['callback']();
    }

    public function setCustomAction(string $action, callable $callback)
    {
        $this->customActions[$action] = [
            'name' => $action,
            'label' => $this->trans($action) ?? Str::title($action),
            'callback' => $callback,
        ];
    }

    final public static function slug(): string
    {
        return once(
            self::$slug,
            fn () => Str::snake(class_basename(static::class), '-')
        );
    }

    final public function transSlug(): string
    {
        return $this->transSlug ?? $this->slug();
    }

    protected function trans(string $key, array $replace = []): ?string
    {
        $key = "modals.{$this->transSlug()}.{$key}";
        $string = __($key, $replace);

        return $string === $key ? null : $string;
    }

    public function render(): View
    {
        return view('livewire.modal');
    }

    public static function closeModalOnEscape(): bool
    {
        return static::$closeModalOnEscape;
    }

    public static function closeModalOnClickAway(): bool
    {
        return static::$closeModalOnClickAway;
    }
}
