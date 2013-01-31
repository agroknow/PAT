<?php 
if (!isset($_GET["section"])){head(array('title'=>'The e-KnowNet Project'));}
elseif ($_GET["section"]=="shortid"){head(array('title'=>'Short ID | The e-KnowNet Project'));}
elseif ($_GET["section"]=="objectives"){head(array('title'=>'Main objectives | The e-KnowNet Project'));}
elseif ($_GET["section"]=="outcomes"){head(array('title'=>'Expected outcomes | The e-KnowNet Project'));}
elseif ($_GET["section"]=="science"){head(array('title'=>'Science Centre Links | The e-KnowNet Project'));}
else {head(array('title'=>'The Partenariat | The e-KnowNet Project'));}


 ?>
<div id="page-body" class="one_column eknownet">
<?php require_once('./themes/natural/common/menu.php'); ?>

<?php if (!isset($_GET["section"])): ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">The e-KnowNet Project</h1>
				<h2 class="section_sub_title">NETWORK FOR ICT-ENABLED NON-FORMAL SCIENCE LEARNING</h2>
		<p>The e-KnowNet project aims to develop a network enabled by information and communication technologies (ICT) in order to facilitate the flow of new scientific knowledge from the research laboratory to larger, non-expert segments of society, in forms suitable for non-formal learning.</p>
	</div><!-- end div.panel -->
<?php elseif ($_GET["section"]=="shortid"): ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">Short ID</h1>
				<ul>
					<li><strong>Start date:</strong> January 2008</b></li>
					<li><strong>End date:</strong> December 2010</b></li>
					<li><strong>Funding framework:</strong> LLP Application - Call EAC/61/2006, Transversal Programme / Key Activity 3: ICT / Networks </li>
					<li><strong>Further information:</strong> <a href="http://www.e-knownet.eu"> http://www.e-knownet.eu </a></li>
				</ul>
	</div><!-- end div.panel -->
<?php elseif ($_GET["section"]=="objectives"): ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">Main objectives</h1>
				<ul>
					<li>Produce an innovative model of a European knowledge-sharing network enabled by Information and Communication Technologies (ICT).</li>
					<li>Trigger new dynamics in ICT-enabled life-long learning, through linking up fields that traditionally have been working in isolation, i.e. scientific research institutions, communities of pedagogical science experts and science centres.</li>
					<li>Promote the educational role of ICT in non-formal environments, such as the science centre/museum.</li>
				</ul>
	</div><!-- end div.panel -->
<?php elseif ($_GET["section"]=="outcomes"): ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">Expected outcomes</h1>
				<ul>
					<li><strong>KNOWLEDGE SHARING WITH THE USE OF ICT</strong> - The "show case" of the project is the <a href="<?php echo uri('home'); ?>">ScienceTweets platform</a>, a virtual depository and a redistributing hub for the dissemination of popularised new scientific knowledge and a virtual meeting place for a variety of learning communities (researchers, science communicators, educators, science centre and school communities). The e-KNOWNET project focuses thematically on <a href="<?php echo uri('intro'); ?>">natural_europe</a>.</li>
					<li><strong>SOCIAL NETWORKING</strong> - Extended networking among complementary knowledge-based organizations such as research institutions, universities, science centres and networking technology providers, and between communities linked to formal and non-formal education.</li>
				</ul>
	</div><!-- end div.panel -->
<?php elseif ($_GET["section"]=="science"): ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">Links with science centres</h1>
		 <p>This networking and collaboration scheme hopes to provide science centres with learning resources produced according to the latest developments of scientific research, and methodological tools suitable for producing similar learning materials. These resources will be available online and offline for lifelong learners who wish to remain updated on the latest developments of scientific research.</p>
         <br />
         <ul>
         	<li><a href="http://www.ecsite.eu/" title="External link: opens in new window" target="_blank" class="tooltip">ECSITE -  European Network of Science Centres and Museums</a></li>
            <li><a href="http://www.astc.org/" title="External link: opens in new window" target="_blank" class="tooltip">ASTC - American Science and Technology Centres</a></li>
            <li><a href="http://www.aspacnet.org/" title="External link: opens in new window" target="_blank" class="tooltip">ASPAC - Asia Pacific Network of Science & Technology Centres</a></li>
         </ul>
	</div><!-- end div.panel -->
<?php else: ?>
<div class="column eknownet" id="column-c">
		<h1 class="section_title">The Partenariat</h1>
 		<p><strong>Five European organisations</strong> active in the fields of science and learning are working together to transform scientific knowledge into learning resources, making use of the learning potential of ICT. Partners learn from each other, share experiences (symbols, vocabulary and jargon, work methods and practices, tools and mentalities) and try to make the most of what the involved communities of experts and practitioners have to offer.</p>
			<ul class="paertnersul" id="paertnersul">
					<li><a href="#eugenides">Eugenides Foundation - Project Coordinator [GR]</a></li>
					<li><a href="#grnetlink">Greek Research & Technology Network S.A. (GRNET) [GR]</a></li>
					<li><a href="#fublink">Freie Universitat Berlin [DE]</a></li>

					<li><a href="#fpllink">Francis Perrin Laboratory CEA - CNRS URA 2453 [FR]</a></li>
					<li><a href="#occlink">University Pompeu Fabra [ES]</a></li>
			</ul>
 
						<h2 id="eugenides" class="section_sub_title">Eugenides Foundation, Athens, Greece (Project Coordinator)</h2>
				<p>The Eugenides Foundation was established in 1956 by Eugene Eugenides, as an independent, non-profit welfare organisation, with a mission to enhance the scientific, technological and technical education in Greece. Since its establishment, the Eugenides Foundation (EF) has become a national hallmark of technical education in Greece. </p>
				<p>The end of the 20th century marked the conception of a new vision for the Eugenides Foundation: that of contributing to the effort of the Greek society to meet the challenges of the 21st century, in the same dynamic and innovative way it had always done since its establishment. </p>

				<p>This new vision is today becoming a reality. The EF has evolved into a multifaceted educational and technological hub, unique in Greece. The New Digital Planetarium of the Eugenides Foundation, the largest and best equipped digital planetarium in the world, opened its gates to the public in November 2003. Since then, it has received more than 1,500,000 visitors. In December 2006, the inauguration of the Interactive Exhibition of Science and Technology by the Prime Minister of the Hellenic Republic crowned the celebrations for the Eugenides Foundation's 50th Anniversary. This new, permanent exhibition developed to the highest standards of science museology, is dedicated to current issues of science and technology. By offering educational stimuli in an attractive, intriguing and pleasant way, it hopes to instill the desire for scientific and technological exploration in people of all ages.</p>
				<p>Wishing to respond to urgent and up to date societal needs, the Eugenides Foundation is expanding its activities. It wishes to contribute to the development of an environment that would allow for: a) a more balanced information flow to the citizen on S&T issues, b) the sensitization of the non-expert on scientific and technological advances and innovation and c) a more responsible decision making in Research and Technology. </p>
				<p>The function of the fully renovated Eugenides Foundation is based upon the following main activities:</p>
				<ul>
                    <li>The New Digital Planetarium, equipped to present digital shows and large-format films,</li>
                    <li>A state of the art Interactive Science and Technology Exhibition</li>
                    <li>New publishing activities</li>
                    <li>A library, with multimedia applications and distance learning technology</li>
                    <li>Expanded educational activities and collaborations</li>
                    <li>Educational scholarships </li>
                    <li>Modern convention facilities.</li>
				</ul>
				<div class="contact_details">
				<p><strong>CONTACT PERSONS</strong></p>
				<p>Glykeria Anyfandi, Content Coordinator, tel: +30 - 210 9469646</p>
				<p>Christina Troumpetari, Project Management, tel: +30 - 210 9469626</p>
				<p>e-mail: <a href="emailto:public@e-knownet.eu">public@e-knownet.eu</a></p>
				<br />
				<p>Eugenides Foundation, 387 Syngrou Ave, Athens, GR 17564, GREECE</p>
				<p>tel: +30 - 210 9469600, fax: +30 - 210 9430171</p>
				<p><a class="tooltip" href="http://www.eugenfound.edu.gr">http://www.eugenfound.edu.gr</a></p>
				<a href="#paertnersul" class="top_anchor">Back to top</a>
				</div><!--end contact_details-->
				<h2 id="grnetlink" class="section_sub_title">Greek Research and Technology Network (GRNET), Athens, Greece (Partner)</h2>
				<p>The Greek Research and Technology Network (GRNET) supports the research and development of Information and Communication Technologies (ICT) within Greece and internationally, through the provision of its high-capacity networking and grid computing infrastructure, the strengthening of e-Learning & e-Business practices, as well as the participation in international research and education efforts. GRNET operates under the auspices of the Ministry of Development and is supervised by the General Secretariat for Research and Development.  GRNET develops and provides advanced services of national and international internet access to the Research, Academic and Education communities of Greece, with its gigabit GRNET2 network and the Virtual NOC supportive scheme. The network connects 27 Universities, 15 Technical Universities, 33 Research Institutions and 12,673 schools to the Pan-European Research and Education Network, GEANT. GRNET is also promoting the use of Broad-Band technologies in Greece and administers the Athens Internet Exchange (AIX), through which the Greek Internet Service Providers interconnect. GRNET's networking infrastructure serves as the foundation for advanced computing applications, taking advantage of the processing/storage clusters that reside in different parts of the country and sophisticated middleware developed by our European collaborators. The resulting computing grid is the subject of the HellasGrid national project, coordinated by GRNET. GRNET supports national and international actions which aim at the integration of e-Learning, Internet technologies and their use within the Greek business environment, with a focus on Small to Medium-sized Enterprises (SMEs). In this framework, GRNET coordinates the e-Business Forum project, the project for the educational support of the GoOnline programme and the EU-funded ELISA project. GRNET participates actively in a multitude of international projects funded by the European Union, including 6DISS, EUMedConnect, EUMedGrid, ForSociety, ACTION, and others, for the advance of digital technologies in Europe and the world.
				</p>
 				<div class="contact_details">
				<p><strong>CONTACT PERSON</strong></p>
				<p>Dr. Xenophon TSILIBARIS</p>
				<p>Programme Management and Administration</p>
				<p>GRNET S.A., 56, Messogion Av.</p>
				<p>115 27 Athens, Greece</p>

				<p>tel: +30 210 7474 261</p>
				<p>fax: +30 210 7474 490</p>
				<p>WEB: <a class="external_link" href="http://www.grnet.gr/">http://www.grnet.gr/</a></p>
				<a href="#paertnersul" class="top_anchor">Back to top</a>
				</div><!--end contact_details-->
				<h2 id="fublink" class="section_sub_title">Free University of Berlin - Center for Digital Systems, Competence Center e-Learning/ Multimedia, Berlin, Germany (Partner)</h2>

				<p>Freie Universit?t Berlin is one of the largest universities in Germany, offering degree courses in more than a hundred subjects for 39,200 students - of whom 15 per cent come from other countries. Without including the School of Medicine, Freie Universitaet is currently lead university for eight collaborative research centers of the German Research Foundation DFG (Deutsche Forschungsgemeinschaft). Freie Universit?t also cooperates closely with international companies such as BMW, Schering, Siemens, Deutsche Telekom, and Pfizer.</p><p> The Center for Digital Systems - Competence Center e-Learning/Multimedia (CeDiS) disposes of wide experiences in conception, realization and service of IT infrastructures at the Freie Universit?t Berlin (FU) and in the creation of interactive teaching/ learning materials for education and advanced education.</p><p> Development of multimedia learning systems for higher education following approved concepts and models, CeDiS offers a wide range of IT-services based on innovative technologies. CeDiS presents regulary popular scientific content to the public at the big annual event "Long Night of Science" in Berlin. In addition, CeDiS was responsible for the realization of the e-exhibit about the History and Profile of the Freie Universit?t Berlin in 2004 on the occasion of the 50th birthday of the Henry Ford Building (financed by the American Ford Foundation).</p> 
				<div class="contact_details">
				<p><strong>CONTACT PERSON</strong></p>
				<p>Dr. Nicolas Apostolopoulos (Managing Director)</p>
				<p>Freie Universitaet Berlin</p>
				<p>Center for Digital Systems (CeDiS),</p>
				<p>Competence Center-Learning/Multimedia</p>
				<br />
				<p>Ihnestrasse 24, 14195 Berlin, Germany</p>
				<p>Phone: +49.30.8385-2050 Fax: +49.30.8385-2843</p>
				<p>E-Mail: Nicolas Apostolopoulos NApo@CeDiS.FU-Berlin.de</p>
				<p>WEB: <a class="external_link" href="http://WWW.CeDiS.FU-Berlin.de">http://WWW.CeDiS.FU-Berlin.de</a></p>
				<a href="#paertnersul" class="top_anchor">Back to top</a>
				</div><!--end contact_details-->
				<h2 id="fpllink" class="section_sub_title">Francis Perrin Laboratory (Commissariat ? l'?nergie Atomique/Centre National de la Recherche Scientifique), France.</h2> 
				<p>The Francis Perrin Laboratory (FPL) is a joint research unit of the Atomic Energy Commissariat (CEA) and the National Centre for the Scientific Research (CNRS) and is located 20km outside Paris. It has about thirty permanent research scientists and technicians; some twenty PhD students and post-docs are trained there. The FPL conducts research in the field of physical chemistry by focusing on the interaction of light with molecular systems, including biomolecules and nanostructures. </p> 
				<p>Light is used to induce various processes (photoluminescence, energy and charge transfer, photoreactions) or to probe different types of molecular systems both in their ground and their excited states. </p>
				<p>An important part of the studies is carried out using state of the art lasers and spectroscopic techniques. The various research projects are organized in four groups:</p>
				<p>1. <u>Excited Biomolecules:</u> The group works with biomolecules in solution using mainly time-resolved techniques (from the femtosecond to the millisecond time-scales). Most of the studies concern the interaction of UV radiation with DNA components. The aim is to understand how UV light induces photochemical reactions which may lead to carcinogenic mutations and ultimately to skin cancer.</p>

				<p>2. <u>Biomolecular Structures:</u> The group focuses on molecules allowing the elucidation of questions arising from the field of biology. The geometry and the dynamics of these molecules are investigated by means of modern laser and simulation techniques.  </p>
				<p>3. <u>Reaction Dynamics:</u> The group investigates the forces which are responsible for a photochemical reaction, using among others, femtosecond lasers. In order to obtain a refined description of the involved processes, molecules and aggregates are studied isolated in the gas phase. </p>
				<p>4. <u>Nanostructures:</u> The objective of the group is to control the synthesis of nano-objects or nanostructures materials, using for example laser pyrolysis, to study their specific properties (photoluminescence, photocatalysis etc.) and to explore their potential applications. </p>

				<p>During the last four years the FPL published 140 articles in peer reviewed journals (<i>Nature, Angewante Chemie, Nanoletters, Journal of the American Chemical Society,</i> etc.). Some important results are disseminated toward a broader public mainly via pathways developed by the mother institutions, CEA and CNRS.</p>
				<div class="contact_details">
				<p><strong>CONTACT PERSON</strong></p>
				<p>Dr Dimitra Markovitsi, CNRS Research Director</p>
				<p>Head of the Francis Perrin Laboratory</p>
				<p>CEA/Saclay, B. 522</p>
				<p>91191 Gif-sur-Yvette, France</p>
				<p>TEL: 33 (0)1 69 08 46 44</p>
				<p>WEB: <a class="external_link" href="http://www-lfp.cea.fr">http://www-lfp.cea.fr</a></p>
				<a href="#paertnersul" class="top_anchor">Back to top</a>
				</div><!--end contact_details-->
				<h2 id="occlink" class="section_sub_title">Science Communication Observatory / Universitat Pompeu Fabra, Barcelona, Spain.</h2>
				<p>The Science Communication Observatory (OCC) is a Special Research Centre attached to the Department of Communication of the Pompeu Fabra University in Barcelona, Spain. Set up in 1994, the centre specializes in the study and analysis of the transmission of scientific, medical, environmental and technological knowledge to society. The journalist Vladimir de Semir, associate professor of Science Journalism at the Pompeu Fabra University, was the founder and is the current director of the centre. A multidisciplinary team of researchers coming from different backgrounds (i.e. journalists, biologists, physicians, linguists, historians, etc.) is working on various fields of research: science communication; crisis communication; science communication and knowledge representation; journalism specialized in science and technology; discourse analysis; health and medicine in the daily press; relationships between science journals and mass media; history of science communication; public understanding of science; gender and science in the mass media, promotion of scientific vocations, etc.</p> 
				<p>The Science Communication Observatory is linked to the international network on Public Communication of Science & Technology (PCST), which includes individuals from around the world who are active in producing and studying PCST through science journalism, science museums and science centers, academic researchers in social and experimental sciences, scientists who deal with the public, public information officers for scientific institutions and others related to science in society issues.</p>
				<p>The Science Communication Observatory runs a Master in Science, Medical and Environmental Communication in Barcelona since 1995 and a Diploma in Science Communication in Buenos Aires (Argentina) since 2008, as well as other courses and workshops about science communication and the popularization of science. The Science Communication Observatory also publishes Quark, a journal] about "Science, Medicine, Communication and Culture", and also carries on research and analysis in the Science in Society field, working with other academic groups on several European projects</p>
				<div class="contact_details last">
				<p><strong>CONTACT PERSON</strong></p>
 				<p>Vladimir de Semir</p>
				<p>Observatori de la Comunicaci? Cient?fica - Universitat Pompeu Fabra</p>
				<p>Edifici Franca - Passeig de la Circumval lacio, 8</p>
				<p>08003 - Barcelona (SPAIN)</p>
				<p>Tel: +34.93.5422446, Fax: +34 93 2689349</p>
				<p>e-mail: <a href="mailto:occ@upf.edu">occ@upf.edu</a></p>
				<p>WEB: <a class="external_link" href="http://www.upf.edu/occ">http://www.upf.edu/occ</a></p>
				<a href="#paertnersul" class="top_anchor">Back to top</a>
				</div><!--end contact_details-->
		</div>
	</div><!-- end div.panel -->
<?php endif;?>
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>