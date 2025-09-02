/* globals jQuery */
/******
 * This file only gets enqueued on a page where Gravity Forms is active
 * Available classes: firstname, lastname, email, phone
 */

jQuery( document ).ready( ( $ ) => {
	let errors = [];

	function showErrorMessage( event, error, errorWrapper ) {
		event.currentTarget.children[2].firstChild.style.borderColor = 'red';
		errorWrapper.innerText = error;
		errorWrapper.style.display = 'block';
		if ( $.inArray( error, errors ) === -1 ) {
			errors.push(error);
		}
	}

	function removeErrorMessage( event, error, errorWrapper ) {
		event.currentTarget.children[2].firstChild.style.borderColor = 'green';
		if ( $.inArray( error, errors ) !== -1 ) {
			const index = $.inArray( error, errors );
			errors.splice( index, 1 );
		}
		errorWrapper.innerText = '';
		errorWrapper.style.display = 'none';
	}

	// Add an error div beneath each form field
	$( '.gform_wrapper' ).each( function() {
		$( this ).prepend( '<div class="all-errors-field"></div>' );
	});

	// Add an error div beneath each form field
	$( '.gfield' ).each( function() {
		$( this ).append( '<div class="error-field"></div>' );
	});

	// Run a function everytime a key-up has been recognised
	$( '.gfield' ).on( 'keyup', function( e ) {
		const fieldWrapper = $( this )[ 0 ],
		 currentValue = e.target.value,
		 errorWrapper = fieldWrapper.lastChild,
		 classList = e.currentTarget.classList;

		// Name checks
		if ( classList.contains( 'firstname' ) || classList.contains( 'lastname' ) ) {
			const error = classList.contains( 'firstname' ) ? 'Voornaam mag alleen letters bevatten.' : 'Achternaam mag alleen letters bevatten.';
			// Only allow alphabetic characters
			if ( /[^a-z ]/i.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// Streetname checks
		if ( classList.contains( 'streetname' ) ) {
			const error = 'De straatnaam mag alleen letters en spaties bevatten.';
			// Only allow alphabetic characters
			if ( /[^a-z ]/i.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// City checks
		if ( classList.contains( 'city' ) ) {
			const error = 'De plaatsnaam mag alleen letters en spaties bevatten.';
			// Only allow alphabetic characters
			if ( /[^a-z ]/i.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// Email checks
		if ( classList.contains( 'email' ) ) {
			let error = 'Vul een geldig e-mailadres in.',
			 extension = currentValue.split( '.' ),
			 extensionTypos = [ 'con', 'co', 'n', 'vom', 'cm', 'cok', 'om', 'nl' ];
			extension = extension[ extension.length - 1 ];
			// Validate email
			if ( ! /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else if ( extensionTypos.includes( extension ) ) {
				error = 'We herkennen deze email extensie niet, bedoel je .com of .nl?';
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
				removeErrorMessage( e, 'We herkennen deze email extensie niet, bedoel je .com of .nl?', errorWrapper );
			}
		}

		// Phone checks
		if ( classList.contains( 'phone' ) ) {
			const error = 'Het telefoonnummer mag alleen cijfers bevatten.';
			// Only allow numeric characters
			if ( /[^0-9]/i.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// House number checks
		if ( classList.contains( 'housenumber' ) ) {
			const error = 'Het huisnummer mag alleen cijfers bevatten.';
			// Only allow numeric characters
			if ( /[^0-9]/i.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// Addition checks
		if ( classList.contains( 'addition' ) ) {
			const error = 'De huisnummer toevoeging mag alleen één hoofdletter bevatten.';
			// Only allow numeric characters
			if ( ! /[A-Z]{1}$/.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// Postal code checks
		if ( classList.contains( 'postal-code' ) ) {
			const error = 'Vul een juiste postcode in (vb. 1234AB).';
			// Only allow numeric characters
			if ( ! /^[1-9][0-9]{3} ?(?!sa|sd|ss)[A-Z]{2}$/.test( currentValue ) ) {
				showErrorMessage( e, error, errorWrapper );
			} else {
				removeErrorMessage( e, error, errorWrapper );
			}
		}

		// Show/hide the error collector div
		$( '.all-errors-field' )[0].style.display = ( errors.length > 0 ) ? 'block' : 'none';

		// Create the list markup
		let errorList = '<ul aria-live>';
		errors.forEach( function( error ) {
			errorList += `<li>${error}</li>`;
		} );
		errorList += '</ul>';

		// Append the list to the wrapper
		$( '.all-errors-field' ).html( errorList );
	} );
} );
