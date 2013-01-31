 <script>
     jQuery.noConflict();
   </script>
   
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/users/css/tree.css'); ?>" charset="utf-8">
<script src="<?php echo uri('themes/natural/users/jquery.checkboxtree.js'); ?>" type="text/javascript" language="JavaScript"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#checkchildren").checkboxTree({
			collapsedarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-collapsed.gif'); ?> ",
			expandedarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-expanded.gif'); ?>",
			blankarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-blank.gif'); ?>",
			checkchildren: true,
			checkparents: false

	});
	
		jQuery("#checkchildren2").checkboxTree({
			collapsedarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-collapsed.gif'); ?> ",
			expandedarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-expanded.gif'); ?>",
			blankarrow: "<?php echo uri('themes/natural/users/images/checkboxtree/img-arrow-blank.gif'); ?>",
			checkchildren: true,
			checkparents: false

	});
	
});
</script>

<?php if(!isset($user)) {
	$user = new User;
	$user->setArray($_POST);
} 
?>

<?php echo flash(); ?>
<fieldset>
<div class="field">
	<label><?php text(array('name'=>'username', 'class'=>'textinput', 'id'=>'username'),$user->username, 'Username*'); ?></label>
	<?php echo form_error('username'); ?>
</div>

<div class="field">
	<?php text(array('name'=>'first_name', 'class'=>'textinput', 'id'=>'first_name'),not_empty_or($user->first_name, $_POST['first_name']), 'First Name*'); ?>
	<?php echo form_error('first_name'); ?>
</div>

<div class="field">
	<?php text(array('name'=>'last_name', 'class'=>'textinput', 'id'=>'last_name'),not_empty_or($user->last_name, $_POST['last_name']), 'Last Name*'); ?>
	<?php echo form_error('last_name'); ?>
</div>

<div class="field">
	<?php text(array('name'=>'email', 'class'=>'textinput', 'id'=>'email'), not_empty_or($user->email, $_POST['email']), 'Email*'); ?>
	<?php echo form_error('email'); ?>
</div>
	<div class="field">
		<label for="Country">Select a Country*</label>
		<select name="country" id="country">
			<option value="">Please select</option>
				<option value="Afghanistan">Afghanistan</option>
				<option value="Aland">Aland</option>
				<option value="Albania">Albania</option>
				<option value="Algeria">Algeria</option>
				<option value="American Samoa">American Samoa</option>
				<option value="Andorra">Andorra</option>
				<option value="Angola">Angola</option>
				<option value="Anguilla">Anguilla</option>
				<option value="Antarctica">Antarctica</option>
				<option value="Antigua and Barbuda">Antigua and Barbuda</option>
				<option value="Argentina">Argentina</option>
				<option value="Armenia">Armenia</option>
				<option value="Aruba">Aruba</option>
				<option value="Ascension Island">Ascension Island</option>
				<option value="Australia">Australia</option>
				<option value="Austria">Austria</option>
				<option value="Azerbaijan">Azerbaijan</option>
				<option value="Bahamas">Bahamas</option>
				<option value="Bahrain">Bahrain</option>
				<option value="Bangladesh">Bangladesh</option>
				<option value="Barbados">Barbados</option>
				<option value="Belarus">Belarus</option>
				<option value="Belgium">Belgium</option>
				<option value="Belize">Belize</option>
				<option value="Benin">Benin</option>
				<option value="Bermuda">Bermuda</option>
				<option value="Bhutan">Bhutan</option>
				<option value="Bolivia">Bolivia</option>
				<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
				<option value="Botswana">Botswana</option>
				<option value="Brazil">Brazil</option>
				<option value="Brunei">Brunei</option>
				<option value="Bulgaria">Bulgaria</option>
				<option value="Burkina Faso">Burkina Faso</option>
				<option value="Burundi">Burundi</option>
				<option value="Buvet Island">Buvet Island</option>
				<option value="Cambodia">Cambodia</option>
				<option value="Cameroon">Cameroon</option>
				<option value="Canada">Canada</option>
				<option value="Cape Verde">Cape Verde</option>
				<option value="Cayman Islands">Cayman Islands</option>
				<option value="Central African Republic">Central African Republic</option>
				<option value="Chad">Chad</option>
				<option value="Chile">Chile</option>
				<option value="China">China</option>
				<option value="Christmas Island">Christmas Island</option>
				<option value="Cocos Islands">Cocos Islands</option>
				<option value="Colombia">Colombia</option>
				<option value="Comoros">Comoros</option>
				<option value="Congo">Congo</option>
				<option value="Congo Democratic Republic">Congo Democratic Republic</option>
				<option value="Cook Islands">Cook Islands</option>
				<option value="Costa Rica">Costa Rica</option>
				<option value="Co^te d'Ivoire">Co^te d'Ivoire</option>
				<option value="Croatia">Croatia</option>
				<option value="Cuba">Cuba</option>
				<option value="Cyprus">Cyprus</option>
				<option value="Czech Republic">Czech Republic</option>
				<option value="Denmark">Denmark</option>
				<option value="Djibouti">Djibouti</option>
				<option value="Dominica">Dominica</option>
				<option value="Dominican Republic">Dominican Republic</option>
				<option value="East Timor">East Timor</option>
				<option value="Ecuador">Ecuador</option>
				<option value="Egypt">Egypt</option>
				<option value="El Salvador">El Salvador</option>
				<option value="Equatorial Guinea">Equatorial Guinea</option>
				<option value="Eritrea">Eritrea</option>
				<option value="Estonia">Estonia</option>
				<option value="Ethiopia">Ethiopia</option>
				<option value="Europe">Europe</option>
				<option value="Falkland Islands">Falkland Islands</option>
				<option value="Faroe Islands">Faroe Islands</option>
				<option value="Fiji">Fiji</option>
				<option value="Finland">Finland</option>
				<option value="Former Yugoslav Republic of Macedonia">Former Yugoslav Republic of Macedonia</option>
				<option value="France">France</option>
				<option value="French Guiana">French Guiana</option>
				<option value="French Polynesia">French Polynesia</option>
				<option value="Gabon">Gabon</option>
				<option value="Gambia">Gambia</option>
				<option value="Georgia">Georgia</option>
				<option value="Germany">Germany</option>
				<option value="Ghana">Ghana</option>
				<option value="Gibraltar">Gibraltar</option>
				<option value="Gouadeloupe">Gouadeloupe</option>
				<option value="Greece">Greece</option>
				<option value="Greenland">Greenland</option>
				<option value="Grenada">Grenada</option>
				<option value="Guam">Guam</option>
				<option value="Guatemala">Guatemala</option>
				<option value="Guernsey">Guernsey</option>
				<option value="Guinea">Guinea</option>
				<option value="Guinea-Bissau">Guinea-Bissau</option>
				<option value="Guyana">Guyana</option>
				<option value="Haiti">Haiti</option>
				<option value="Honduras">Honduras</option>
				<option value="Hong Kong">Hong Kong</option>
				<option value="Hungary">Hungary</option>
				<option value="Iceland">Iceland</option>
				<option value="India">India</option>
				<option value="Indonesia">Indonesia</option>
				<option value="Iran">Iran</option>
				<option value="Iraq">Iraq</option>
				<option value="Ireland (Republic of Ireland)">Ireland (Republic of Ireland)</option>
				<option value="Isle of Man">Isle of Man</option>
				<option value="Israel">Israel</option>
				<option value="Italy">Italy</option>
				<option value="Jamaica">Jamaica</option>
				<option value="Japan">Japan</option>
				<option value="Jersey">Jersey</option>
				<option value="Jordan">Jordan</option>
				<option value="Kazakhstan">Kazakhstan</option>
				<option value="Kenya">Kenya</option>
				<option value="Kiribati">Kiribati</option>
				<option value="Korea (North)">Korea (North)</option>
				<option value="Korea (South)">Korea (South)</option>
				<option value="Kuwait">Kuwait</option>
				<option value="Kyrgyzstan">Kyrgyzstan</option>
				<option value="Laos">Laos</option>
				<option value="Latvia">Latvia</option>
				<option value="Lebanon">Lebanon</option>
				<option value="Lesotho">Lesotho</option>
				<option value="Liberia">Liberia</option>
				<option value="Libya">Libya</option>
				<option value="Liechtenstein">Liechtenstein</option>
				<option value="Lithuania">Lithuania</option>
				<option value="Luxembourg">Luxembourg</option>
				<option value="Macao">Macao</option>
				<option value="Madagascar">Madagascar</option>
				<option value="Malawi">Malawi</option>
				<option value="Malaysia">Malaysia</option>
				<option value="Maldives">Maldives</option>
				<option value="Mali">Mali</option>
				<option value="Malta">Malta</option>
				<option value="Marshall Islands">Marshall Islands</option>
				<option value="Martinique">Martinique</option>
				<option value="Mauritania">Mauritania</option>
				<option value="Mauritius">Mauritius</option>
				<option value="Mayotte">Mayotte</option>
				<option value="Mexico">Mexico</option>
				<option value="Micronesia">Micronesia</option>
				<option value="Moldova">Moldova</option>
				<option value="Monaco">Monaco</option>
				<option value="Mongolia">Mongolia</option>
				<option value="Montenegro">Montenegro</option>
				<option value="Montserrat">Montserrat</option>
				<option value="Morocco">Morocco</option>
				<option value="Mozambique">Mozambique</option>
				<option value="Myanmar">Myanmar</option>
				<option value="Namibia">Namibia</option>
				<option value="Nauru">Nauru</option>
				<option value="Nepal">Nepal</option>
				<option value="Netherlands">Netherlands</option>
				<option value="Netherlands Antilles">Netherlands Antilles</option>
				<option value="New Caledonia">New Caledonia</option>
				<option value="New Zealand">New Zealand</option>
				<option value="Nicaragua">Nicaragua</option>
				<option value="Niger">Niger</option>
				<option value="Nigeria">Nigeria</option>
				<option value="Niue">Niue</option>
				<option value="Norfolk Island">Norfolk Island</option>
				<option value="Northern Mariana Islands">Northern Mariana Islands</option>
				<option value="Norway">Norway</option>
				<option value="Oman">Oman</option>
				<option value="Pakistan">Pakistan</option>
				<option value="Palau">Palau</option>
				<option value="Palestine">Palestine</option>
				<option value="Panama">Panama</option>
				<option value="Papua New Guinea">Papua New Guinea</option>
				<option value="Paraguay">Paraguay</option>
				<option value="Peru">Peru</option>
				<option value="Philippines">Philippines</option>
				<option value="Pitcairn Islands">Pitcairn Islands</option>
				<option value="Poland">Poland</option>
				<option value="Portugal">Portugal</option>
				<option value="Puerto Rico">Puerto Rico</option>
				<option value="Qatar">Qatar</option>
				<option value="Re'union">Re'union</option>
				<option value="Romania">Romania</option>
				<option value="Russia">Russia</option>
				<option value="Rwanda">Rwanda</option>
				<option value="Sahrawi Arab Democratic Republic">Sahrawi Arab Democratic Republic</option>
				<option value="Saint-Barthe'lemy">Saint-Barthe'lemy</option>
				<option value="Saint Helena">Saint Helena</option>
				<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
				<option value="Saint Lucia">Saint Lucia</option>
				<option value="Saint Martin">Saint Martin</option>
				<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
				<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
				<option value="Samoa">Samoa</option>
				<option value="San Marino">San Marino</option>
				<option value="Sa~o Tome' and Pri'ncipe">Sa~o Tome' and Pri'ncipe</option>
				<option value="Saudi Arabia">Saudi Arabia</option>
				<option value="Senegal">Senegal</option>
				<option value="Serbia">Serbia</option>
				<option value="Seychelles">Seychelles</option>
				<option value="Sierra Leone">Sierra Leone</option>
				<option value="Singapore">Singapore</option>
				<option value="Slovakia">Slovakia</option>
				<option value="Slovenia">Slovenia</option>
				<option value="Solomon Islands">Solomon Islands</option>
				<option value="Somalia">Somalia</option>
				<option value="South Africa">South Africa</option>
				<option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
				<option value="Spain">Spain</option>
				<option value="Sri Lanka">Sri Lanka</option>
				<option value="Sudan">Sudan</option>
				<option value="Suriname">Suriname</option>
				<option value="Svalbard">Svalbard</option>
				<option value="Swaziland">Swaziland</option>
				<option value="Sweden">Sweden</option>
				<option value="Switzerland">Switzerland</option>
				<option value="Syria">Syria</option>
				<option value="Taiwan">Taiwan</option>
				<option value="Tajikistan">Tajikistan</option>
				<option value="Tanzania">Tanzania</option>
				<option value="Thailand">Thailand</option>
				<option value="Togo">Togo</option>
				<option value="Tokelau">Tokelau</option>
				<option value="Tonga">Tonga</option>
				<option value="Trinidad and Tobago">Trinidad and Tobago</option>
				<option value="Tristan da Cunha">Tristan da Cunha</option>
				<option value="Tunisia">Tunisia</option>
				<option value="Turkey">Turkey</option>
				<option value="Turkmenistan">Turkmenistan</option>
				<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
				<option value="Tuvalu">Tuvalu</option>
				<option value="Uganda">Uganda</option>
				<option value="Ukraine">Ukraine</option>
				<option value="United Arab Emirates">United Arab Emirates</option>
				<option value="United Kingdom">United Kingdom</option>
				<option value="United States of America">United States of America</option>
				<option value="Uruguay">Uruguay</option>
				<option value="Uzbekistan">Uzbekistan</option>
				<option value="Vanuatu">Vanuatu</option>
				<option value="Vatican City">Vatican City</option>
				<option value="Venezuela">Venezuela</option>
				<option value="Vietnam">Vietnam</option>
				<option value="Virgin Islands, British">Virgin Islands, British</option>
				<option value="Virgin Islands, United States">Virgin Islands, United States</option>
				<option value="Wallis and Futuna">Wallis and Futuna</option>
				<option value="Yemen">Yemen</option>
				<option value="Zambia">Zambia</option>
				<option value="Zimbabwe">Zimbabwe</option>
		</select>
		<?php echo form_error('Country'); ?>
		<?php //$_POST['role'] = 'researcher';?>
		<?php //select(array('name'=>'role','id'=>'role'),get_user_roles(), not_empty_or($user->role, $_POST['role']), 'I am a*'); ?>
		<?php //echo form_error('role'); ?>
	</div>
<div class="field">
<input type="hidden" name="role" id="role" value="Science center staff" >

		<!--<label for="role">Select a user profile*</label>
		<select name="role" id="role">
		<option value="">Select below</option>
		<option value="Student">Student</option>
		<option value="Science center staff">Science center staff</option>
		<option value="Lifelong learner">Lifelong learner</option>
		<option value="Researcher">Researcher</option>
		</select>
		<?php //$_POST['role'] = 'researcher';?>
		<?php //select(array('name'=>'role','id'=>'role'),get_user_roles(), not_empty_or($user->role, $_POST['role']), 'I am a*'); ?>
		<?php //echo form_error('role'); ?>
	</div>-->
<div class="field">
<?php text(array('name'=>'organization', 'class'=>'textinput', 'id'=>'organization'),not_empty_or($user->organization, $_POST['organization']), 'My organization/Institution'); ?>
<?php //echo form_error('organization'); ?>
</div>




<div class="common_lifelong_students" style="display:none;">
        
		<div class="field">
<?php text(array('name'=>'my_hobbies', 'class'=>'textinput', 'id'=>'my_hobbies'),not_empty_or($user->my_hobbies, $_POST['my_hobbies']), 'My hobbies'); ?>
<?php echo form_error('my_hobbies'); ?>
</div> 

</div>


<div class="common_staff_researcher" style="display:none;">
        
		<div class="field">
        <?php text(array('name'=>'title', 'class'=>'textinput', 'id'=>'title'),not_empty_or($user->title, $_POST['title']), 'Title'); ?>
		<?php echo form_error('title'); ?>
		</div> 
		 
		<div class="field">
		<?php text(array('name'=>'studies', 'class'=>'textinput', 'id'=>'studies'),not_empty_or($user->studies, $_POST['studies']),'My studies*'); ?>
		<?php echo form_error('studies'); ?>
		</div> 



		<div class="field">
<?php text(array('name'=>'my_science_field_of_interest', 'class'=>'textinput', 'id'=>'my_science_field_of_interest'),not_empty_or($user->my_science_field_of_interest, $_POST['my_science_field_of_interest']),'My science field of interest*'); ?>
<?php echo form_error('my_science_field_of_interest'); ?>
</div>		
	<div class="field">	
<div class="form_instructions"><b style="font-size:7pt;">You can type a science field of interest or select from this list</b></div>

<br />
<ul class="unorderedlisttree" id="checkchildren">
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Agriculture and food supply">
    <span>Agriculture and food supply</span>
    <ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="VETERINARY AND ANIMAL SCIENCES">
        <span>VETERINARY AND ANIMAL SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="AGRICULTURE">
        <span>AGRICULTURE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="FOOD">
        <span>FOOD</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="AGRICULTURAL BIOTECHNOLOGY">
        <span>AGRICULTURAL BIOTECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="RESOURCES OF THE SEA - FISHERIES">
        <span>RESOURCES OF THE SEA - FISHERIES</span>

      </li>
    </ul>
  </li>
  
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Biology and medicine">
    <span>Biology and medicine</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="MEDICINE - HEALTH">
        <span>MEDICINE - HEALTH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="BIOTECHNOLOGY">
        <span>BIOTECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="LIFE SCIENCES">
        <span>LIFE SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="HEALTHCARE DELIVERY/SERVICES">
        <span>HEALTHCARE DELIVERY/SERVICES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="MEDICAL BIOTECHNOLOGY">
        <span>MEDICAL BIOTECHNOLOGY</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Energy">
    <span>Energy</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="NUCLEAR FISSION">
        <span>NUCLEAR FISSION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="NUCLEAR FUSION">
        <span>NUCLEAR FUSION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="FOSSIL FUELS">
        <span>FOSSIL FUELS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="RENEWABLE SOURCES OF ENERGY">
        <span>RENEWABLE SOURCES OF ENERGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ENERGY STORAGE, ENERGY, TRANSPORT">
        <span>ENERGY STORAGE, ENERGY, TRANSPORT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ENERGY SAVING">
        <span>ENERGY SAVING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="BIOFUELS">
        <span>BIOFUELS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="HYDROGEN AND FUEL CELLS">
        <span>HYDROGEN AND FUEL CELLS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="OTHER ENERGY TOPICS">
        <span>OTHER ENERGY TOPICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="CLEAN COAL TECHNOLOGIES">
        <span>CLEAN COAL TECHNOLOGIES</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Environment and climate">
    <span>Environment and climate</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="METEOROLOGY">
        <span>METEOROLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ENVIRONMENTAL PROTECTION">
        <span>ENVIRONMENTAL PROTECTION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="RADIATION PROTECTION">
        <span>RADIATION PROTECTION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="WASTE MANAGEMENT">
        <span>WASTE MANAGEMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="RADIOACTIVE WASTE">
        <span>RADIOACTIVE WASTE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SUSTAINABLE DEVELOPMENT">
        <span>SUSTAINABLE DEVELOPMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="EARTH SCIENCES">
        <span>EARTH SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="CLIMATE CHANGE AND CARBON CYCLE RESEARCH">
        <span>CLIMATE CHANGE AND CARBON CYCLE RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="WATER RESOURCE MANAGEMENT">
        <span>WATER RESOURCE MANAGEMENT</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Industry and industrial technology">
    <span>Industry and industrial technology</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INDUSTRIAL MANUFACTURE">
        <span>INDUSTRIAL MANUFACTURE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="MATERIALS TECHNOLOGY">
        <span>MATERIALS TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="NANOTECHNOLOGY AND NANOSCIENCES">
        <span>NANOTECHNOLOGY AND NANOSCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INDUSTRIAL BIOTECH">
        <span>INDUSTRIAL BIOTECH</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Information and Communication Technology">
    <span>Information and Communication Technology</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ELECTRONICS, MICROELECTRONICS">
        <span>ELECTRONICS, MICROELECTRONICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INFORMATION PROCESSING, INFORMATION SYSTEMS">
        <span>INFORMATION PROCESSING, INFORMATION SYSTEMS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="TELECOMMUNICATIONS">
        <span>TELECOMMUNICATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="AUTOMATION">
        <span>AUTOMATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ROBOTICS">
        <span>ROBOTICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ICT APPLICATIONS">
        <span>ICT APPLICATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="NETWORK TECHNOLOGIES">
        <span>NETWORK TECHNOLOGIES</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Research in practice">
    <span>Research in practice</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="MEASUREMENT METHODS">
        <span>MEASUREMENT METHODS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="MATHEMATICS STATISTICS">
        <span>MATHEMATICS STATISTICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="REFERENCE MATERIALS">
        <span>REFERENCE MATERIALS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SCIENTIFIC RESEARCH">
        <span>SCIENTIFIC RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="PROJECT MANAGEMENT METHODOLOGIES">
        <span>PROJECT MANAGEMENT METHODOLOGIES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="COORDINATION, COOPERATION">
        <span>COORDINATION, COOPERATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="POLICIES">
        <span>POLICIES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="LEGISLATION, REGULATIONS">
        <span>LEGISLATION, REGULATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="FORECASTING">
        <span>FORECASTING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="RESEARCH ETHICS">
        <span>RESEARCH ETHICS</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Research outputs">
    <span>Research outputs</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="EVALUATION">
        <span>EVALUATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="STANDARDS">
        <span>STANDARDS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INNOVATION, TECHNOLOGY TRANSFER">
        <span>INNOVATION, TECHNOLOGY TRANSFER</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="BUSINESS ASPECTS">
        <span>BUSINESS ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INTELLECTUAL PROPERTY RIGHTS">
        <span>INTELLECTUAL PROPERTY RIGHTS</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Social and Economic Concerns">
    <span>Social and Economic Concerns</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SOCIAL ASPECTS">
        <span>SOCIAL ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="EDUCATION, TRAINING">
        <span>EDUCATION, TRAINING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="INFORMATION, MEDIA">
        <span>INFORMATION, MEDIA</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="ECONOMIC ASPECTS">
        <span>ECONOMIC ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="REGIONAL DEVELOPMENT">
        <span>REGIONAL DEVELOPMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="EMPLOYMENT ISSUES">
        <span>EMPLOYMENT ISSUES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SAFETY">
        <span>SAFETY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SECURITY">
        <span>SECURITY</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_science_field_of_interest2[]" value="Transport and Construction">
    <span>Transport and Construction</span>
		<ul>
      <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="CONSTRUCTION TECHNOLOGY">
        <span>CONSTRUCTION TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="TRANSPORT">
        <span>TRANSPORT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="AEROSPACE TECHNOLOGY">
        <span>AEROSPACE TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="SPACE AND SATELLITE RESEARCH">
        <span>SPACE AND SATELLITE RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_science_field_of_interest2[]" value="OTHER TECHNOLOGY">
        <span>OTHER TECHNOLOGY</span>

      </li>
	  
	    </ul>
  </li>
 
 
  

</ul>


</div> 


</div>

<div class="researcher_fileds" style="display:none;">
<div class="field">
<?php text(array('name'=>'my_expertise', 'class'=>'textinput', 'id'=>'my_expertise'),not_empty_or($user->my_expertise, $_POST['my_expertise']), 'My  expertise*'); ?>
<?php //echo form_error('my_expertise'); ?>
</div> 
<div class="field">	
<div class="form_instructions"><b style="font-size:7pt;">You can type keywords that correspond to your expertise area or select from this list</b></div>

<br />

<ul class="unorderedlisttree" id="checkchildren2">
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Agriculture and food supply">
    <span>Agriculture and food supply</span>
    <ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="VETERINARY AND ANIMAL SCIENCES">
        <span>VETERINARY AND ANIMAL SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="AGRICULTURE">
        <span>AGRICULTURE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="FOOD">
        <span>FOOD</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="AGRICULTURAL BIOTECHNOLOGY">
        <span>AGRICULTURAL BIOTECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="RESOURCES OF THE SEA - FISHERIES">
        <span>RESOURCES OF THE SEA - FISHERIES</span>

      </li>
    </ul>
  </li>
  
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Biology and medicine">
    <span>Biology and medicine</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="MEDICINE - HEALTH">
        <span>MEDICINE - HEALTH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="BIOTECHNOLOGY">
        <span>BIOTECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="LIFE SCIENCES">
        <span>LIFE SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="HEALTHCARE DELIVERY/SERVICES">
        <span>HEALTHCARE DELIVERY/SERVICES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="MEDICAL BIOTECHNOLOGY">
        <span>MEDICAL BIOTECHNOLOGY</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Energy">
    <span>Energy</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="NUCLEAR FISSION">
        <span>NUCLEAR FISSION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="NUCLEAR FUSION">
        <span>NUCLEAR FUSION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="FOSSIL FUELS">
        <span>FOSSIL FUELS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="RENEWABLE SOURCES OF ENERGY">
        <span>RENEWABLE SOURCES OF ENERGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ENERGY STORAGE, ENERGY, TRANSPORT">
        <span>ENERGY STORAGE, ENERGY, TRANSPORT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ENERGY SAVING">
        <span>ENERGY SAVING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="BIOFUELS">
        <span>BIOFUELS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="HYDROGEN AND FUEL CELLS">
        <span>HYDROGEN AND FUEL CELLS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="OTHER ENERGY TOPICS">
        <span>OTHER ENERGY TOPICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="CLEAN COAL TECHNOLOGIES">
        <span>CLEAN COAL TECHNOLOGIES</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Environment and climate">
    <span>Environment and climate</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="METEOROLOGY">
        <span>METEOROLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ENVIRONMENTAL PROTECTION">
        <span>ENVIRONMENTAL PROTECTION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="RADIATION PROTECTION">
        <span>RADIATION PROTECTION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="WASTE MANAGEMENT">
        <span>WASTE MANAGEMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="RADIOACTIVE WASTE">
        <span>RADIOACTIVE WASTE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="SUSTAINABLE DEVELOPMENT">
        <span>SUSTAINABLE DEVELOPMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="EARTH SCIENCES">
        <span>EARTH SCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="CLIMATE CHANGE AND CARBON CYCLE RESEARCH">
        <span>CLIMATE CHANGE AND CARBON CYCLE RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="WATER RESOURCE MANAGEMENT">
        <span>WATER RESOURCE MANAGEMENT</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Industry and industrial technology">
    <span>Industry and industrial technology</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="INDUSTRIAL MANUFACTURE">
        <span>INDUSTRIAL MANUFACTURE</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="MATERIALS TECHNOLOGY">
        <span>MATERIALS TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="NANOTECHNOLOGY AND NANOSCIENCES">
        <span>NANOTECHNOLOGY AND NANOSCIENCES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="INDUSTRIAL BIOTECH">
        <span>INDUSTRIAL BIOTECH</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Information and Communication Technology">
    <span>Information and Communication Technology</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="ELECTRONICS, MICROELECTRONICS">
        <span>ELECTRONICS, MICROELECTRONICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="INFORMATION PROCESSING, INFORMATION SYSTEMS">
        <span>INFORMATION PROCESSING, INFORMATION SYSTEMS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="TELECOMMUNICATIONS">
        <span>TELECOMMUNICATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="AUTOMATION">
        <span>AUTOMATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ROBOTICS">
        <span>ROBOTICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ICT APPLICATIONS">
        <span>ICT APPLICATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="NETWORK TECHNOLOGIES">
        <span>NETWORK TECHNOLOGIES</span>

      </li>
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Research in practice">
    <span>Research in practice</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="MEASUREMENT METHODS">
        <span>MEASUREMENT METHODS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="MATHEMATICS STATISTICS">
        <span>MATHEMATICS STATISTICS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="REFERENCE MATERIALS">
        <span>REFERENCE MATERIALS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="SCIENTIFIC RESEARCH">
        <span>SCIENTIFIC RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="PROJECT MANAGEMENT METHODOLOGIES">
        <span>PROJECT MANAGEMENT METHODOLOGIES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="COORDINATION, COOPERATION">
        <span>COORDINATION, COOPERATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="POLICIES">
        <span>POLICIES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="LEGISLATION, REGULATIONS">
        <span>LEGISLATION, REGULATIONS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="FORECASTING">
        <span>FORECASTING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="RESEARCH ETHICS">
        <span>RESEARCH ETHICS</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Research outputs">
    <span>Research outputs</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="EVALUATION">
        <span>EVALUATION</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="STANDARDS">
        <span>STANDARDS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="INNOVATION, TECHNOLOGY TRANSFER">
        <span>INNOVATION, TECHNOLOGY TRANSFER</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="BUSINESS ASPECTS">
        <span>BUSINESS ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="INTELLECTUAL PROPERTY RIGHTS">
        <span>INTELLECTUAL PROPERTY RIGHTS</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Social and Economic Concerns">
    <span>Social and Economic Concerns</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="SOCIAL ASPECTS">
        <span>SOCIAL ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="EDUCATION, TRAINING">
        <span>EDUCATION, TRAINING</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="INFORMATION, MEDIA">
        <span>INFORMATION, MEDIA</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="ECONOMIC ASPECTS">
        <span>ECONOMIC ASPECTS</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="REGIONAL DEVELOPMENT">
        <span>REGIONAL DEVELOPMENT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="EMPLOYMENT ISSUES">
        <span>EMPLOYMENT ISSUES</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="SAFETY">
        <span>SAFETY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="SECURITY">
        <span>SECURITY</span>

      </li>
	  
	    </ul>
  </li>
  <li>
    <input type="checkbox" name="my_expertise2[]" value="Transport and Construction">
    <span>Transport and Construction</span>
		<ul>
      <li>
        <input type="checkbox" name="my_expertise2[]" value="CONSTRUCTION TECHNOLOGY">
        <span>CONSTRUCTION TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="TRANSPORT">
        <span>TRANSPORT</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="AEROSPACE TECHNOLOGY">
        <span>AEROSPACE TECHNOLOGY</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="SPACE AND SATELLITE RESEARCH">
        <span>SPACE AND SATELLITE RESEARCH</span>

      </li>
	  <li>
        <input type="checkbox" name="my_expertise2[]" value="OTHER TECHNOLOGY">
        <span>OTHER TECHNOLOGY</span>

      </li>
	  
	    </ul>
  </li>
 
 
  

</ul>



</div>
</div>



<div class="staff" style="display:none;">
		

</div>
		

<!--<div class="radio">
<label>Subscribe to newsletter</label><input type="checkbox" name="newsletter" class="" checked="checked" />
</div>
<div class="radio">
<label>I agree to the Terms of Use and Privacy Policy.</label><input type="checkbox" name="terms" class="" checked="checked" />
</div>-->
</fieldset>
<script>
 jQuery(document).ready(function() {
        //jQuery('div.textfield1').hide();
		jQuery('div.researcher_fileds').hide();
		jQuery('div.staff').hide();
		jQuery('div.common_staff_researcher').hide();
		jQuery('div.common_lifelong_students').hide();
        jQuery('#role').change(function() {

                if (jQuery("#role").val() == 'Researcher'){
				        jQuery('div.common_staff_researcher').show();
						jQuery('div.common_lifelong_students').hide();
                        jQuery('div.researcher_fileds').show();
						jQuery('div.staff').hide();
						jQuery('div.textfield1').hide();
						
                }
				else if (jQuery("#role").val() == 'Science center staff'){
				        jQuery('div.common_staff_researcher').show();
						jQuery('div.common_lifelong_students').hide();
                        jQuery('div.staff').show();
						jQuery('div.researcher_fileds').hide();
						jQuery('div.textfield1').hide();
                }
				else if (jQuery("#role").val() == 'Student' || jQuery("#role").val() == 'Lifelong learner'){
				        jQuery('div.common_staff_researcher').hide();
						jQuery('div.common_lifelong_students').show();
                        jQuery('div.textfield1').show();
						jQuery('div.staff').hide();
						jQuery('div.researcher_fileds').hide();
                }
                else{
				        jQuery('div.common_staff_researcher').hide();
						jQuery('div.common_lifelong_students').hide();
                        jQuery('div.researcher_fileds').hide();
						jQuery('div.staff').hide();
						jQuery('div.textfield1').hide();
                }
   });
});
</script>