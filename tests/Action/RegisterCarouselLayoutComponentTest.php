<?php

namespace IM\Fabric\Plugin\DynamicContent\Test\Action;

use IM\Fabric\Package\FormWrapper\Form\Component;
use IM\Fabric\Package\FormWrapper\Form\RuleCollection;
use IM\Fabric\Package\FormWrapper\Service\ComponentRegistrationInterface;
use IM\Fabric\Package\WordPress\Action\Action;
use IM\Fabric\Plugin\DynamicContent\Action\RegisterCarouselLayoutComponent;
use IM\Fabric\Plugin\DynamicContent\Factory\ACF\LayoutComponentFactory;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Mockery;

class RegisterCarouselLayoutComponentTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private ComponentRegistrationInterface $registration;
    private LayoutComponentFactory $componentFactory;
    private RegisterCarouselLayoutComponent $component;

    public function setUp(): void
    {
        $this->componentFactory = Mockery::mock(LayoutComponentFactory::class);
        $this->componentFactory->allows('create')->andReturn(Mockery::mock(Component::class));

        $this->registration = Mockery::mock(ComponentRegistrationInterface::class);

        $this->component = new RegisterCarouselLayoutComponent(
            $this->registration,
            $this->componentFactory
        );
    }

    public function testClassExtendsAction()
    {
        $this->assertInstanceOf(Action::class, $this->component);
    }

    public function testRegisterLayoutComponentAction()
    {
        $this->registration->expects('register')
            ->with(Component::class, RuleCollection::class);

        $this->component->action();
    }
}
