<?php

use Contributte\Invoice\Data\Extension\IDiscount;
use Contributte\Invoice\Data\Extension\IPriceWithTax;
use Contributte\Invoice\Templates\Template\ParaisoTemplateObject;
use WebChemistry\SvgPdf\Utility\TemplateUtility;

/** @var $template ParaisoTemplateObject */
$formatMoney = $template->formatMoneyCallback();
$order = $template->getOrder();
$payment = $order->getPayment();

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<svg xmlns="http://www.w3.org/2000/svg" width="2480" height="3508">
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        * {
            font-family: Montserrat;
        }
        p { margin: 0; }
	</style>
	<!-- Header Text -->
	<text font-size="136" x="1678" y="206" fill="<?= $this->colors['text'] ?>" font-weight="bold" text-anchor="start"><?= TemplateUtility::escape(strtoupper($template->translate('Invoice'))) ?></text>
	<!-- / Header Text -->


	<!-- Invoice From -->
	<?php $y = TemplateUtility::multiplier(206 - 43, 55 + 4); ?>
	<?php foreach ($template->getInvoiceFrom() as $i => $item): ?>

		<?php if ($i < 2): ?>
			<text font-size="<?= $i === 1 ? 67 : 50 ?>" x="176" y="<?= $y->additional($i === 1 ? 17 : 0) ?>" fill="<?= $this->colors['text'] ?>" <?php if ($i === 1) echo 'font-weight="bold"'; ?> text-anchor="start"><?= TemplateUtility::escape($item) ?></text>
		<?php endif; ?>

		<?php if ($i >= 2): ?>
			<text font-size="40" x="176" y="<?= $y->additional(-10) ?>" fill="<?= $this->colors['text'] ?>" text-anchor="start"><?= TemplateUtility::escape($item) ?></text>
		<?php endif; ?>

	<?php endforeach; ?>
	<!-- / Invoice From -->


	<!-- Invoice To -->
	<?php $y = TemplateUtility::multiplier(587, 55 + 4); ?>
	<?php foreach ($template->getInvoiceTo() as $i => $item): ?>

		<?php if ($i < 2): ?>
			<text font-size="<?= $i === 1 ? 67 : 50 ?>" x="176" y="<?= $y->additional($i === 1 ? 17 : 0) ?>" fill="<?= $this->colors['text'] ?>" <?php if ($i === 1) echo 'font-weight="bold"'; ?> text-anchor="start"><?= TemplateUtility::escape($item) ?></text>
		<?php endif; ?>

		<?php if ($i >= 2): ?>
			<text font-size="40" x="176" y="<?= $y->additional(-10) ?>" fill="<?= $this->colors['text'] ?>" text-anchor="start"><?= TemplateUtility::escape($item) ?></text>
		<?php endif; ?>

	<?php endforeach; ?>
	<!-- / Invoice To -->

	<!-- Invoice Date-->
	<?php $y = TemplateUtility::multiplier(587, 55 + 4); ?>
	<?php foreach ($template->getInvoiceInfo() as $item): ?>
	<text font-size="50" x="1678" y="<?= $y ?>" fill="<?= $this->colors['lightText'] ?>" text-anchor="start"><?= TemplateUtility::escape($item) ?></text>
	<?php endforeach; ?>
	<!-- / Invoice Date -->


	<!-- Total Due -->
	<text font-size="67" x="1678" y="878" fill="<?= $this->colors['totalDue'] ?>" text-anchor="start"><?= TemplateUtility::escape($template->translate('Total price')) ?>:</text>
	<text font-size="67" x="1678" y="959" fill="<?= $this->colors['primary'] ?>" font-weight="bold" text-anchor="start"><?= TemplateUtility::escape($formatMoney($order->getTotalPrice())) ?></text>
	<!-- / Total Due -->

	<rect x="0" y="1133" width="2480" height="5" fill="<?= $this->colors['primary'] ?>" />

	<text font-size="42" x="176" y="1190" fill="<?= $this->colors['primary'] ?>">Item description</text>
	<text font-size="42" x="1231" y="1190" fill="<?= $this->colors['primary'] ?>" text-anchor="middle">Unit price</text>
	<text font-size="42" x="1680" y="1190" fill="<?= $this->colors['primary'] ?>" text-anchor="middle">Quantity</text>
	<text font-size="42" x="2174" y="1190" fill="<?= $this->colors['primary'] ?>" text-anchor="middle">Total</text>

	<?php $y = TemplateUtility::multiplier(1278, 29 + 100, false); ?>
	<?php foreach ($order->getItems() as $item): ?>
	<switch>
		<foreignObject x="176" y="<?= $y ?>" width="800" height="200" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
			<p xmlns="http://www.w3.org/1999/xhtml" style="font-size:32px;color:#5f6f73"><?= TemplateUtility::escape($item->getName()) ?></p>
		</foreignObject>
		<text font-size="32" x="176" y="<?= $y ?>" fill="#5f6f73" data-pdf-border="0" data-pdf-width="800"><?= TemplateUtility::escape($item->getName()) ?></text>
	</switch>

	<switch>
		<foreignObject x="1031" y="<?= $y ?>" width="400" height="200" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
			<p xmlns="http://www.w3.org/1999/xhtml" style="font-size:42px;color:#5f6f73;text-align:center;"><?= TemplateUtility::escape($item->getQuantity()) ?></p>
		</foreignObject>
		<text font-size="42" x="1031" y="<?= $y ?>" fill="#5f6f73" text-anchor="middle" data-pdf-width="400"><?= TemplateUtility::escape($formatMoney($item->getUnitPrice())) ?></text>
	</switch>

	<switch>
		<foreignObject x="1580" y="<?= $y ?>" width="200" height="200" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
		<p xmlns="http://www.w3.org/1999/xhtml" style="font-size:42px;color:#5f6f73;text-align:center;"><?= TemplateUtility::escape($item->getQuantity()) ?></p>
		</foreignObject>
		<text font-size="42" x="1580" y="<?= $y ?>" fill="#5f6f73" text-anchor="middle" data-pdf-width="200"><?= TemplateUtility::escape($item->getQuantity()) ?></text>
	</switch>

	<switch>
		<foreignObject x="1974" y="<?= $y ?>" width="400" height="200" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
			<p xmlns="http://www.w3.org/1999/xhtml" style="font-size:42px;text-align:center;color:#5f6f73"><?= TemplateUtility::escape($item->getTotalPrice()) ?></p>
		</foreignObject>
		<text font-size="42" x="1974" y="<?= $y ?>" fill="#5f6f73" text-anchor="middle" data-pdf-width="400"><?= TemplateUtility::escape($formatMoney($item->getTotalPrice())) ?></text>
	</switch>

	<?php $y->increment(); endforeach; ?>


	<rect x="0" y="<?= $y; ?>" width="2480" height="5" fill="<?= $this->colors['primary'] ?>" />

	<?php $adjust = $y->increment(); ?>

	<?php
	$y = TemplateUtility::multiplier($adjust, 42 + 30, false);
	?>

	<?php if ($payment instanceof IPriceWithTax): ?>
		<text font-size="42" x="1593" y="<?= $y; ?>" fill="#5f6f73">Sub Total:</text>
		<text font-size="42" x="2250" y="<?= $y->postIncrement(); ?>" text-anchor="end" fill="#5f6f73"><?= TemplateUtility::escape($formatMoney($payment->getPriceBeforeTax())) ?></text>

		<text font-size="42" x="1593" y="<?= $y; ?>" fill="#5f6f73">Tax:</text>
		<text font-size="42" x="2250" y="<?= $y->postIncrement(); ?>" text-anchor="end" fill="#5f6f73"><?= TemplateUtility::escape($formatMoney($payment->getTax())) ?></text>
	<?php endif; ?>

	<?php if ($order instanceof IDiscount): ?>
		<text font-size="42" x="1593" y="<?= $y; ?>" fill="#5f6f73"><?= TemplateUtility::escape($template->translate('Discount')) ?>:</text>
		<text font-size="42" x="2250" y="<?= $y->postIncrement(); ?>" text-anchor="end" fill="#5f6f73"><?= TemplateUtility::escape($formatMoney($order->getDiscount())) ?></text>
	<?php endif; ?>

	<text font-size="42" x="1593" y="<?= $y; ?>" font-weight="bold" fill="#5f6f73">Total</text>
	<text font-size="42" x="2250" y="<?= $y; ?>" font-weight="bold" text-anchor="end" fill="#5f6f73">$ 4500.00</text>

	<?php $paymentY = TemplateUtility::multiplier($adjust, 42 + 30); ?>
	<?php if ($template->getPaymentInfo()): ?>
		<text font-size="54" x="178" y="<?= $paymentY->additional(12); ?>" color="<?= $this->colors['text'] ?>"><?= TemplateUtility::escape($template->translate('Payment Info')) ?></text>
		<?php foreach ($template->getPaymentInfo() as $info): ?>
			<text font-size="42" x="178" y="<?= $paymentY; ?>" fill="#5f6f73"><?= TemplateUtility::escape($info) ?></text>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php $y = ($y->current() > $paymentY->current()) ? $y->current() : $paymentY->current(); ?>

	<?php if ($template->getFooter()): ?>
		<switch>
			<foreignObject x="640" y="<?= $y + 180 ?>" width="1200" height="200" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
				<p xmlns="http://www.w3.org/1999/xhtml" style="font-size:42px;text-align:center;color:#5f6f73"><?= TemplateUtility::escape($template->getFooter()) ?></p>
			</foreignObject>
			<text font-size="42" x="640" y="<?= $y + 180 ?>" fill="#5f6f73" text-anchor="middle" data-pdf-width="1200"><?= TemplateUtility::escape($template->getFooter()) ?></text>
		</switch>
	<?php endif; ?>

</svg>
