<?php
/**
 * Created by PhpStorm.
 * User: holmes
 * Date: 10/1/18
 * Time: 12:03 PM
 */


// Add Shortcode
function tdgp_shortcode() { ?>

	<div class="flex-it-container">
		<div style="width:55%;">
			<p>Our non-worded <abbr title="Transportation of Dangerous Goods">TDG</abbr> placards are available for all nine hazard classes, DANGER, and marine pollutant. These placards measure 10<abbr title="inch">"</abbr> x 10<abbr title="inch">"</abbr> (273 <abbr title="millimeter">mm</abbr> x 273 <abbr title="millimeter">mm</abbr>), and are suitable for bulk, rail cars, <abbr title="Intermediate Bulk Containers">IBCs</abbr>, totes, <abbr title="Less than Load">LTL</abbr>, and truckload. All placards are available blank or pre-printed with <abbr title="United Nations">UN</abbr> number. Blank placards enable UN numbers to be added on-demand. Pre-printed placards have the UN number printed ahead of time for immediate use. Material options include tagboard, rigid vinyl, pressure-sensitive removable vinyl, and pressure-sensitive permanent vinyl. </p>
			<p>All placards comply with 49 <abbr title="Code of Federal Regulations">CFR</abbr> Part 172, Subpart 172.332 in the US, and <abbr title="Transportation of Dangerous Goods">TDG</abbr> Part 4 - Dangerous Goods Safety Marks in Canada. Ideal for use in all weather conditions.</p>
			<p>Unsure of which hazard class placard you need? Enter the 4-digit UN number below.</p>
		</div>
		<div style="width:40%; text-align:center;">
			<h4><abbr title="Transportation of Dangerous Goods">TDG</abbr> Non-worded Placards</h4>
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/tdg-non-worded-placards.svg" width="80%" />
			<h4 style="padding-top:20px;">Blank/Pre-printed <abbr title="United Nations">UN</abbr> Number Placards</h4>
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/tdg-worded-placards.svg" width="80%" />
		</div>
	</div>

	<div class="tdg-placard-lookup-container">
				<? // Gather form informationa and look up the placards.
			$the_un_number  = isset( $_POST[ 'un_number' ] ) ? $_POST[ 'un_number' ] : NULL;

			// Debug entered number
			// echo $the_un_number . '<br />';

			// Convert entered number to a string
			$the_un_number_string = (string) $the_un_number;

			// Count the characters entered in the number
			$un_number_char_entered = strlen ( $the_un_number_string );

			// Test the count length and add the approprate content for querying
			if ( $un_number_char_entered == 1 ) {
				// If only one was entered, complete the un number by adding UN000
				$the_full_un_number = "UN000" . $the_un_number_string;

			} elseif ( $un_number_char_entered == 2 ) {
				// If only two were entered, complete the un number by adding UN00
				$the_full_un_number = "UN00" . $the_un_number_string;

			} elseif ( $un_number_char_entered == 3 ) {
				// If only three were entered, complete the un number by adding UN0
				$the_full_un_number = "UN0" . $the_un_number_string;

			} else {
				// If all four were entered, complete the un number by adding UN
				$the_full_un_number = "UN" . $the_un_number_string;
			}

			// Debug the full un number
			// echo $the_full_un_number . '<br />';

			// Grab the wpdb global
			global $wpdb;

			// Set the table name
			$table_name = $wpdb->prefix . "tdg_placards";

			// Debug the table name
			// echo $table_name . '<br />';

			// Write the SQL for the search
			$sql = "SELECT * FROM $table_name
			WHERE un_number = '$the_full_un_number'";

			// Debug the search sql
			// echo $sql . '<br />';

			// Assign the Results
			$the_placards = $wpdb->get_results( $sql, ARRAY_A );
		?>

		<!-- Debug the Results -->
		<!-- <pre><? print_r( $the_placards ); ?></pre> -->



		<?
		$how_many_placards = count( $the_placards);

		if ( $how_many_placards > 1 ) {
			echo '<h2>There are ' . $how_many_placards . ' placard results for ' . $the_full_un_number . '</h2>';
		} elseif ( $how_many_placards == 1 ) {
			echo '<h2>There is ' . $how_many_placards . ' placard result for ' . $the_full_un_number . '</h2>';
		} elseif ( isset( $_POST[ 'un_number' ] ) && $how_many_placards == 0 ) {
			echo '<h2>There is no chemical associated with that number.<br />Please search again.</h2>';
		} else {
			echo '<h2>Look up the <abbr title="Transportation of Dangerous Goods">TDG</abbr> placard you need</h2>';
		}

		foreach ( $the_placards as $the_placard ) {

			// Grab the Class Number
			$the_class = $the_placard['class'];

			// Debug the Class Number
			// echo 'Class : ' . $the_class . '<br/>';

			// Replace all periods, spaces, & opening and closing parens
			$the_class = str_replace( ".", "", $the_class );
			$the_class = str_replace( " ", "", $the_class );
			$the_class = str_replace( "(", "", $the_class );
			$the_class = str_replace( ")", "", $the_class );

			// Debug the replacements.
			// echo 'Class Replaced : ' . $the_class . '<br/>';

			// Set image name.
			$the_image = $the_class . ".svg";

			// Debug Image Name
			// echo 'Image : ' . $the_image . '<br/>';

			$link_leader = substr( $the_image, 0, 1 );

			// DISPLAY THE FEEDBACK ?>
			<div class="flex-it-container tdg-placard-results">
				<div class="placard-image">
					<? if ( $the_full_un_number == 'UN1072' || $the_full_un_number == 'UN1073' || $the_full_un_number == 'UN3156' || $the_full_un_number == 'UN3157' ) { ?>
						<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/2251.svg" alt="Class 2.2 (5.1) Placard">
					<? } else { ?>
						<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/<? echo $the_image; ?>" alt="Class <? echo $the_placard['class']; ?> Placard">
					<? } ?>
				</div>

				<div class="placard-information">
					<dl class="tdg-placards">
						<dt style="font-size: 1.25em;">Shipping Name &amp; Description:</dt>
						<? if ( $the_placard['shipping_name'] == NULL ) { ?>
							<dd style="font-size: 1.25em;"> - </dd>
						<? } else { ?>
							<dd style="font-size: 1.25em;"><? echo $the_placard['shipping_name']; ?></dd>
						<? } ?>

						<dt><abbr title="United Nations">UN</abbr> Number:</dt>
						<? if ( $the_placard['un_number'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['un_number']; ?></dd>
						<? } ?>

						<dt>Class:</dt>
						<? if ( $the_placard['class'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['class']; ?></dd>
						<? } ?>

						<dt>Packing Group/Category:</dt>
						<? if ( $the_placard['packing_group'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['packing_group']; ?></dd>
						<? } ?>

						<dt>Special Provisions</dt>
						<? if ( $the_placard['special_provisions'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['special_provisions']; ?></dd>
						<? } ?>

						<dt>Explosive Limit &amp; Limited Quantity Index:</dt>
						<? if ( $the_placard['lq_index'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['lq_index']; ?></dd>
						<? } ?>

						<dt>Excepted Quantities:</dt>
						<? if ( $the_placard['excepted_quantities'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['excepted_quantities']; ?></dd>
						<? } ?>

						<dt><abbr title="Emergency Response Assistance Plan">ERAP</abbr> Index: </dt>
						<? if ( $the_placard['erap'] == NULL ) { ?>
							<dd> - </dd>
						<? } else { ?>
							<dd><? echo $the_placard['erap']; ?></dd>
						<? } ?>

						<dt>Passenger Carrying Vessel Index: </dt>
						<? if ( $the_placard['passenger_ship_index'] == NULL ) { ?>
							<dd> - </dd>
						<? } elseif ( $the_placard['passenger_ship_index'] == "Forbidden" ) { ?>
							<dd class="forbidden"><? echo $the_placard['passenger_ship_index']; ?></dd>
						<? } else { ?>
							<dd><? echo $the_placard['passenger_ship_index']; ?></dd>
						<? } ?>

						<dt>Passenger Carrying Road Vehicle Index: </dt>
						<? if ( $the_placard['passenger_road_rail_index'] == NULL ) { ?>
							<dd> - </dd>
						<? } elseif ( $the_placard['passenger_road_rail_index'] == "Forbidden" ) { ?>
							<dd class="forbidden"><? echo $the_placard['passenger_road_rail_index']; ?></dd>
						<? } else { ?>
							<dd><? echo $the_placard['passenger_road_rail_index']; ?></dd>
						<? } ?>

						<dt>Passenger Carrying Railway Vehicle Index: </dt>
						<? if ( $the_placard['passenger_road_rail_index'] == NULL ) { ?>
							<dd> - </dd>
						<? } elseif ( $the_placard['passenger_road_rail_index'] == "Forbidden" ) { ?>
							<dd class="forbidden"><? echo $the_placard['passenger_road_rail_index']; ?></dd>
						<? } else { ?>
							<dd><? echo $the_placard['passenger_road_rail_index']; ?></dd>
						<? } ?>

						<!-- Check the class of the placard with $link_leader and then display the correct links to the store. -->
						<!-- TODO: Allow the user to update these links in a settings page. -->
						<? switch ( $link_leader ) {
								case ( 1 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+1+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>';
									break;
								case ( 2 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+2+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+1+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 3 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-3?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+3+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-3?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+3+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 4 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+4+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+4+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 5 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+5+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+5+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 6 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-6?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+6+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-6?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+6+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 7 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-7?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+7+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-7?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+7+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 8 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-8?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+8+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-8?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+8+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
								case ( 9 ) :
									echo '<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-9?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+9+Search" target="_blank" rel="noopener" style="margin-right:20px;">Buy this placard</a>
												<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-9?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=Class+9+Search+Bulk" target="_blank" rel="noopener">Buy a blank or pre-printed version of this placard</a>';
									break;
						} ?>
					</dl>
				</div>
			</div>
		<? } ?>





		<form class="tdg_un_number_lookup" method="post">
			<p>
				<label for="un_number">Enter 4-digit <abbr title="United Nations">UN</abbr> Number below</label>
				<input type="number" id="un_number" name="un_number" min="4" max="3534" maxlength="4"> <!-- when there is full browser support add `pattern="\d{4}"` which is regex for 4 digits. -->
			</p>
			<? if ( $the_un_number == NULL ) { ?>
				<p><input type="submit" value="Search" ></p>
			<? } else { ?>
				<p><input type="submit" value="Search Again"></p>
			<? } ?>
			<p style="font-size: .8em;">This form is accurate according to the January 3, 2018 Update of the<br /><a href="https://open.canada.ca/data/en/dataset/197260f1-b5dc-4f53-a036-2541cff379eb" target="_blank" rel="noopener"><abbr title="Transportation of Dangerous Goods">TDG</abbr> Part 4, Dangerous Goods Safety Marks requirements, Schedule 1</a>.</p>

			<p style="font-size: .8em"><strong>Disclaimer:</strong> This <abbr title="United Nations">UN</abbr> number search tool refers only to the <abbr title="Transportation of Dangerous Goods">TDG</abbr> Regulations. It neither incorporates other regulations<br />
				(e.g., <abbr title="International Maritime Dangerous Goods Code">IMDG</abbr>, <abbr title="International Air Transport Association">IATA</abbr>) nor considers the whole shipment. The results display placards that go with which classes and UN numbers.<br />
																Refer to <abbr title="Transportation of Dangerous Goods">TDG</abbr> Regulations, Part 4 for more information. It is the shipper's responsibility to ensure the shipment is marked,<br />
																labelled, and placarded for transport accordingly.</p>
		</form>
	</div>



	<h2>Non-Worded <abbr title="Transportation of Dangerous Goods">TDG</abbr> Placards</h2>
	<p>Dangerous goods shipments are required to be identified with proper safety marks (placards). Select the required placard to view materials and pricing.</p>
	<div class="tdgp-placard-list-container">
		<div class="non-worded-placard">
			Class 1.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/11.svg" alt="Class 1.1 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 1.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/12.svg" alt="Class 1.2 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 1.3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/13.svg" alt="Class 1.3 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 1.4<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/14.svg" alt="Class 1.4 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.4" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 1.5<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/15.svg" alt="Class 1.5 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.5" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 1.6<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/16n.svg" alt="Class 1.6 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-1?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+1.6" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/21.svg" alt="Class 2.1 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+2.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/22.svg" alt="Class 2.2 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+2.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.2 (5.1)<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/2251.svg" alt="Class 2.2 (5.1) Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+2.2+(5.1)" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/23.svg" alt="Class 2.3 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+2.3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/3.svg" alt="Class 3 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-3?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/41.svg" alt="Class 4.1 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+4.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/42.svg" alt="Class 4.2 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+4.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/43.svg" alt="Class 4.3 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+4.3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 5.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/51.svg" alt="Class 5.1 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+5.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 5.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/52.svg" alt="Class 5.2 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+5.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 6.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/61.svg" alt="Class 6.1 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-6?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+6.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 6.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/62.svg" alt="Class 6.2 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-6?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+6.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 7<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/7.svg" alt="Class 7 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-7?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+7" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 8<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/8.svg" alt="Class 8 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-8?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+8" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 9<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/9.svg" alt="Class 9 Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/class-9?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Class+9" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Residue Drums<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/danger.svg" alt="Residue Drum Placard" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/non-worded/danger?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Danger" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Marine Pollutant<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/marine.svg" alt="Marine Pollutant" /><br />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/environmentally-hazardous-substances?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Marine Pollutant" target="_blank" rel="noopener">Buy Now</a>
		</div>
	</div>


	<h2 style="margin-top: 30px;">Blank/Pre-printed <abbr title="United Nations">UN</abbr> Number Placards</h2>
	<p>When dangerous goods are placed in a large means of containment (capacity exceeding 450 <abbr title="Liters">L</abbr>), such as a vehicle or freight container, four (4) primary class placards must be displayed on the large means of containment, one on each side and on each end. These placards can be ordered blank or pre-printed.</p>
	<div class="tdgp-placard-list-container">
		<div class="non-worded-placard">
			Class 2.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un21.svg" alt="Class 2.1 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+2.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un22.svg" alt="Class 2.2 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+2.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.2 (5.1)<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un2251.svg" alt="Class 2.2 (5.1) Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+2.2+(5.1)" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 2.3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un23.svg" alt="Class 2.3 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-2?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+2.3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un3.svg" alt="Class 3 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-3?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un3white.svg" alt="Class 3 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-3?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+3+White+Bottom" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un41.svg" alt="Class 4.1 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+4.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un42.svg" alt="Class 4.2 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+4.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 4.3<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un43.svg" alt="Class 4.3 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-4?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+4.3" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 5.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un51.svg" alt="Class 5.1 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+5.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 5.2<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un52.svg" alt="Class 5.2 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-5?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+5.2" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 6.1<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un6.svg" alt="Class 6.1 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-6?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+6.1" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 7<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un7.svg" alt="Class 7 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-7?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+7" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 8<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un8.svg" alt="Class 8 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-8?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+8" target="_blank" rel="noopener">Buy Now</a>
		</div>
		<div class="non-worded-placard">
			Class 9<br />
			<img src="<? echo plugin_dir_url( __FILE__ ); ?>images/placards/un9.svg" alt="Class 9 Bulk Placard" />
			<a class="btn btn-shop all-caps" href="https://www.thecompliancecenter.com/store/ca/placards/un-numbered-and-blank/class-9?utm_source=tdgplacards.ca&utm_medium=website&utm_campaign=TDG+Placards+Website&utm_content=List+Bulk+Class+9" target="_blank" rel="noopener">Buy Now</a>
		</div>
	</div>




<? }
add_shortcode( 'tdg_placard_lookup', 'tdgp_shortcode' );