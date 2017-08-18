<?php
/**
 * PDF invoice header template that will be visible on every page.
 *
 * This template can be overridden by copying it to youruploadsfolder/woocommerce-pdf-invoices/templates/invoice/simple/yourtemplatename/header.php.
 *
 * HOWEVER, on occasion WooCommerce PDF Invoices will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author  Bas Elbers
 * @package WooCommerce_PDF_Invoices/Templates
 * @version 0.0.1
 */

$templater       = WPI()->templater();
$order           = $templater->order;
$invoice         = $templater->invoice;
$payment_gateway = wc_get_payment_gateway_by_order( $order );
?>

<table cellpadding="0" cellspacing="0">
	<tr class="top">
		<td>
			<?php
			if ( $templater->get_logo_url() ) {
				printf( '<img src="var:company_logo" style="max-height:100px;"/>' );
			} else {
				printf( '<h2>%s</h2>', esc_html( $templater->get_option( 'bewpi_company_name' ) ) );
			}
			?>
		</td>

		<td>
			<?php
			printf( __( 'Παραστατικό #: %s', 'woocommerce-pdf-invoices' ), $invoice->get_formatted_number() );
			printf( '<br />' );
			printf( __( 'Ημερομηνία έκδοσης παραστατικού: %s', 'woocommerce-pdf-invoices' ), $invoice->get_formatted_invoice_date() );
			printf( '<br />' );
			printf( __( 'Ημερομηνία παραγγελίας: %s', 'woocommerce-pdf-invoices' ), $invoice->get_formatted_order_date() );
			printf( '<br />' );
			printf( __( 'Αριθμός παραγγελίας: %s', 'woocommerce-pdf-invoices' ), $order->get_order_number() );

			if ( $payment_gateway ) {
				printf( '<br />' );
				printf( __( 'Τρόπος πληρωμής: %s', 'woocommerce-pdf-invoices' ), $payment_gateway->get_title() );

				// Get PO Number from 'WooCommerce Purchase Order Gateway' plugin.
				if ( 'woocommerce_gateway_purchase_order' === $payment_gateway->get_method_title() ) {
					$po_number = $templater->get_meta( '_po_number' );
					if ( $po_number ) {
						printf( '<br />' );
						printf( __( 'Αριθμός παραγγελίας αγοράς: %s', 'woocommerce-pdf-invoices' ), $po_number );
					}
				}
			}

			// Get VAT Number from 'WooCommerce EU VAT Number' plugin.
			$vat_number = $templater->get_meta( '_vat_number' );
			if ( $vat_number ) {
				printf( '<br />' );
				printf( __( 'ΑΦΜ: %s', 'woocommerce-pdf-invoices' ), $vat_number );
			}
			?>
		</td>
	</tr>
</table>