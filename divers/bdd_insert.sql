USE technote;

# Insertion pour la table groupe
INSERT IGNORE INTO `technote`.`groupe` (id_groupe, libelle) VALUES (1, 'Administrateur');
INSERT IGNORE INTO `technote`.`groupe` (id_groupe, libelle) VALUES (2, 'Modérateur');
INSERT IGNORE INTO `technote`.`groupe` (id_groupe, libelle) VALUES (3, 'Membre');

#Insertion pour la table membre
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Alex', 'alexdu98@gmx.fr', '$2y$12$baWf8sziCXcnYb875dCoKe708LxeQI7AQoO8fskrRcQiQO2jyquSC', '1', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('modo', 'modo@outlook.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('membre', 'membre@outlook.fr', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Tinnarra', 'Tinnarra@live.fr', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Daewyrr', 'Daewyrr@live.fr', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Neldolen', 'Neldolen@gmail.com', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Swarvard', 'Swarvard@gmail.com', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Legosten', 'Legosten@orange.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Iorakilan', 'Iorakilan@gmx.fr', 'mdp', '3', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Volrod', 'Volrod@gmail.com', 'mdp', '3', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Fategard', 'Fategard@monsite.fr', 'mdp', '3', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Gasclyr', 'Gasclyr@sfr.fr', 'mdp', '2', '0');

#Insertion pour la table technote
INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Post enim Chrysippum eum non sane',
  '2016-03-11 09:05:23',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Quis Aristidem non mortuum diligit?</a> <a href=''http://loripsum.net/'' target=''_blank''>Bonum patria: miserum exilium.</a> Eam stabilem appellas. Illis videtur, qui illud non dubitant bonum dicere -; <i>Sed nimis multa.</i> Duo Reges: constructio interrete. Neque enim civitas in seditione beata esse potest nec in discordia dominorum domus; Quasi vero, inquit, perpetua oratio rhetorum solum, non etiam philosophorum sit. </p>

<ul>
	<li>Quonam, inquit, modo?</li>
	<li>Sine ea igitur iucunde negat posse se vivere?</li>
	<li>De ingenio eius in his disputationibus, non de moribus quaeritur.</li>
	<li>Et si in ipsa gubernatione neglegentia est navis eversa, maius est peccatum in auro quam in palea.</li>
</ul>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<p>Ergo, inquit, tibi Q. Summum a vobis bonum voluptas dicitur. <i>An hoc usque quaque, aliter in vita?</i> Torquatus, is qui consul cum Cn. <a href=''http://loripsum.net/'' target=''_blank''>Sed virtutem ipsam inchoavit, nihil amplius.</a> </p>

<p><a href=''http://loripsum.net/'' target=''_blank''>Si quae forte-possumus.</a> Itaque his sapiens semper vacabit. <a href=''http://loripsum.net/'' target=''_blank''>Duo enim genera quae erant, fecit tria.</a> Quas enim kakaw Graeci appellant, vitia malo quam malitias nominare. Quae cum dixisset, finem ille. </p>

<h2>Neque solum ea communia, verum etiam paria esse dixerunt.</h2>

<p><code>Scrupulum, inquam, abeunti;</code> <a href=''http://loripsum.net/'' target=''_blank''>Sed nunc, quod agimus;</a> Negat enim summo bono afferre incrementum diem. Theophrasti igitur, inquit, tibi liber ille placet de beata vita? Eorum enim est haec querela, qui sibi cari sunt seseque diligunt. Pauca mutat vel plura sane; <a href=''http://loripsum.net/'' target=''_blank''>Nunc omni virtuti vitium contrario nomine opponitur.</a> Scisse enim te quis coarguere possit? Quae similitudo in genere etiam humano apparet. </p>

<dl>
	<dt><dfn>Non igitur bene.</dfn></dt>
	<dd>Non quaero, quid dicat, sed quid convenienter possit rationi et sententiae suae dicere.</dd>
	<dt><dfn>Scrupulum, inquam, abeunti;</dfn></dt>
	<dd>Post enim Chrysippum eum non sane est disputatum.</dd>
	<dt><dfn>Quid Zeno?</dfn></dt>
	<dd>Atque ut ceteri dicere existimantur melius quam facere, sic hi mihi videntur facere melius quam dicere.</dd>
	<dt><dfn>Haeret in salebra.</dfn></dt>
	<dd>Quare, quoniam de primis naturae commodis satis dietum est nunc de maioribus consequentibusque videamus.</dd>
	<dt><dfn>Cur haec eadem Democritus?</dfn></dt>
	<dd>Et ille ridens: Video, inquit, quid agas;</dd>
</dl>


<ol>
	<li>Graece donan, Latine voluptatem vocant.</li>
	<li>Re mihi non aeque satisfacit, et quidem locis pluribus.</li>
	<li>Quid affers, cur Thorius, cur Caius Postumius, cur omnium horum magister, Orata, non iucundissime vixerit?</li>
	<li>Diodorus, eius auditor, adiungit ad honestatem vacuitatem doloris.</li>
	<li>O magnam vim ingenii causamque iustam, cur nova existeret disciplina! Perge porro.</li>
</ol>


<p>Tibi hoc incredibile, quod beatissimum. Negat esse eam, inquit, propter se expetendam. <b>Paria sunt igitur.</b> <b>Urgent tamen et nihil remittunt.</b> <b>Verum hoc idem saepe faciamus.</b> Sed quae tandem ista ratio est? Ut placet, inquit, etsi enim illud erat aptius, aequum cuique concedere. <i>Pugnant Stoici cum Peripateticis.</i> Si quidem, inquit, tollerem, sed relinquo. Sed ad bona praeterita redeamus. Non enim quaero quid verum, sed quid cuique dicendum sit. <i>Ostendit pedes et pectus.</i> </p>

<pre>
Quem enim ardorem studii censetis fuisse in Archimede, qui
dum in pulvere quaedam describit attentius, ne patriam
quidem captam esse senserit?

Sed ad bona praeterita redeamus.
</pre>',
  '1',
  'http://www.zdnet.fr/i/edit/ne/2014/09/ngn-intro-hub-140x105.jpg',
  '2016-03-11 09:06:23',
  '1',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel sagittis leo. Cras ullamcorper, dolor in venenatis porta, ex odio vehicula est, tempor vestibulum nisl felis sed metus. Mauris sed nibh ut ipsum pharetra laoreet non vitae nisl. Morbi at eros facilisis, ultrices turpis a cras amet.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Tamen a proposito',
  '2016-03-11 15:05:10',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Satisne vobis videor pro meo iure in vestris auribus commentatus? Duo Reges: constructio interrete. Mihi enim satis est, ipsis non satis. <a href=''http://loripsum.net/'' target=''_blank''>Avaritiamne minuis?</a> <b>Non semper, inquam;</b> Hoc etsi multimodis reprehendi potest, tamen accipio, quod dant. Sed ad rem redeamus; An est aliquid, quod te sua sponte delectet? </p>

<ul>
	<li>Nunc ita separantur, ut disiuncta sint, quo nihil potest esse perversius.</li>
	<li>Quid ei reliquisti, nisi te, quoquo modo loqueretur, intellegere, quid diceret?</li>
	<li>Ergo adhuc, quantum equidem intellego, causa non videtur fuisse mutandi nominis.</li>
	<li>At enim, qua in vita est aliquid mali, ea beata esse non potest.</li>
	<li>Inquit, dasne adolescenti veniam?</li>
	<li>Atque hoc loco similitudines eas, quibus illi uti solent, dissimillimas proferebas.</li>
</ul>


<ol>
	<li>Ac tamen, ne cui loco non videatur esse responsum, pauca etiam nunc dicam ad reliquam orationem tuam.</li>
	<li>Octavio fuit, cum illam severitatem in eo filio adhibuit, quem in adoptionem D.</li>
	<li>Cum id quoque, ut cupiebat, audivisset, evelli iussit eam, qua erat transfixus, hastam.</li>
	<li>Ergo illi intellegunt quid Epicurus dicat, ego non intellego?</li>
	<li>Et ais, si una littera commota sit, fore tota ut labet disciplina.</li>
</ol>


<h2>Dic in quovis conventu te omnia facere, ne doleas.</h2>

<p><i>Videamus animi partes, quarum est conspectus illustrior;</i> Refert tamen, quo modo. Vos autem cum perspicuis dubia debeatis illustrare, dubiis perspicua conamini tollere. Unum est sine dolore esse, alterum cum voluptate. <code>Haec quo modo conveniant, non sane intellego.</code> <a href=''http://loripsum.net/'' target=''_blank''>Sequitur disserendi ratio cognitioque naturae;</a> Quae hic rei publicae vulnera inponebat, eadem ille sanabat. </p>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<h3>Praeteritis, inquit, gaudeo.</h3>

<p>Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat; Vestri haec verecundius, illi fortasse constantius. <b>Rationis enim perfectio est virtus;</b> Res enim se praeclare habebat, et quidem in utraque parte. <b>Dicimus aliquem hilare vivere;</b> Pauca mutat vel plura sane; <code>Quid iudicant sensus?</code> </p>

<p><b>Videsne quam sit magna dissensio?</b> <i>Idemne, quod iucunde?</i> Sed eum qui audiebant, quoad poterant, defendebant sententiam suam. Si autem id non concedatur, non continuo vita beata tollitur. <code>Videsne, ut haec concinant?</code> Quia voluptatem hanc esse sentiunt omnes, quam sensus accipiens movetur et iucunditate quadam perfunditur. </p>

<p>At ille non pertimuit saneque fidenter: Istis quidem ipsis verbis, inquit; <i>Id mihi magnum videtur.</i> <b>Sint ista Graecorum;</b> </p>

<pre>
Ergo adhuc, quantum equidem intellego, causa non videtur
fuisse mutandi nominis.

Ego autem tibi, Piso, assentior usu hoc venire, ut acrius
aliquanto et attentius de claris viris locorum admonitu
cogitemus.
</pre>


<dl>
	<dt><dfn>Immo alio genere;</dfn></dt>
	<dd>A quibus propter discendi cupiditatem videmus ultimas terras esse peragratas.</dd>
	<dt><dfn>Tu quidem reddes;</dfn></dt>
	<dd>Familiares nostros, credo, Sironem dicis et Philodemum, cum optimos viros, tum homines doctissimos.</dd>
	<dt><dfn>Sed haec omittamus;</dfn></dt>
	<dd>Quare attendo te studiose et, quaecumque rebus iis, de quibus hic sermo est, nomina inponis, memoriae mando;</dd>
	<dt><dfn>Quibusnam praeteritis?</dfn></dt>
	<dd>Iam id ipsum absurdum, maximum malum neglegi.</dd>
</dl>',
  '1',
  'http://news360x.fr/wp-content/uploads/2015/12/Internet1.jpg',
  NULL,
  NULL,
  'Ita multo sanguine profuso in laetitia et in victoria est mortuus. Quod autem ratione actum est, id officium appellamus. Nondum autem explanatum satis, erat, quid maxime natura vellet.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Quamquam te quidem video minime esse deterritum',
  '2016-03-12 10:25:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Pauca mutat vel plura sane;</a> Neque solum ea communia, verum etiam paria esse dixerunt. Duo Reges: constructio interrete. <i>Quid sequatur, quid repugnet, vident.</i> Videamus igitur sententias eorum, tum ad verba redeamus. De quibus cupio scire quid sentias. Haec bene dicuntur, nec ego repugno, sed inter sese ipsa pugnant. Tum Quintus: Est plane, Piso, ut dicis, inquit. Ut optime, secundum naturam affectum esse possit. Indicant pueri, in quibus ut in speculis natura cernitur. Et quod est munus, quod opus sapientiae? Nam ista vestra: Si gravis, brevis; </p>

<p><a href=''http://loripsum.net/'' target=''_blank''>Certe non potest.</a> Hic nihil fuit, quod quaereremus. Huic mori optimum esse propter desperationem sapientiae, illi propter spem vivere. Sin tantum modo ad indicia veteris memoriae cognoscenda, curiosorum. <a href=''http://loripsum.net/'' target=''_blank''>Paria sunt igitur.</a> Hunc vos beatum; </p>

<ol>
	<li>Non enim solum Torquatus dixit quid sentiret, sed etiam cur.</li>
	<li>Quodsi vultum tibi, si incessum fingeres, quo gravior viderere, non esses tui similis;</li>
	<li>Neque enim disputari sine reprehensione nec cum iracundia aut pertinacia recte disputari potest.</li>
	<li>Vitiosum est enim in dividendo partem in genere numerare.</li>
	<li>Isto modo ne improbos quidem, si essent boni viri.</li>
	<li>Te enim iudicem aequum puto, modo quae dicat ille bene noris.</li>
</ol>


<p>Ita multo sanguine profuso in laetitia et in victoria est mortuus. Quod autem ratione actum est, id officium appellamus. Nondum autem explanatum satis, erat, quid maxime natura vellet. <code>Satis est ad hoc responsum.</code> Moriatur, inquit. Itaque nostrum est-quod nostrum dico, artis est-ad ea principia, quae accepimus. </p>

<pre>
Te autem hortamur omnes, currentem quidem, ut spero, ut eos,
quos novisse vis, imitari etiam velis.

Praeclare, inquit, facis, cum et eorum memoriam tenes,
quorum uterque tibi testamento liberos suos commendavit, et
puerum diligis.
</pre>


<ul>
	<li>Collige omnia, quae soletis: Praesidium amicorum.</li>
	<li>Ita est quoddam commune officium sapientis et insipientis, ex quo efficitur versari in iis, quae media dicamus.</li>
	<li>Nam si beatus umquam fuisset, beatam vitam usque ad illum a Cyro extructum rogum pertulisset.</li>
	<li>Et quidem iure fortasse, sed tamen non gravissimum est testimonium multitudinis.</li>
</ul>


<dl>
	<dt><dfn>Quare attende, quaeso.</dfn></dt>
	<dd>Aliena dixit in physicis nec ea ipsa, quae tibi probarentur;</dd>
	<dt><dfn>Age sane, inquam.</dfn></dt>
	<dd>Que Manilium, ab iisque M.</dd>
</dl>


<p>Vitiosum est enim in dividendo partem in genere numerare. Sed tamen enitar et, si minus multa mihi occurrent, non fugiam ista popularia. Nescio quo modo praetervolavit oratio. <a href=''http://loripsum.net/'' target=''_blank''>Quodsi ipsam honestatem undique pertectam atque absolutam.</a> <mark>Vide, quantum, inquam, fallare, Torquate.</mark> </p>

<p><a href=''http://loripsum.net/'' target=''_blank''>Nam Pyrrho, Aristo, Erillus iam diu abiecti.</a> Si quicquam extra virtutem habeatur in bonis. Nullus est igitur cuiusquam dies natalis. <a href=''http://loripsum.net/'' target=''_blank''>Beatum, inquit.</a> <code>Ecce aliud simile dissimile.</code> Si qua in iis corrigere voluit, deteriora fecit. <b>Erit enim mecum, si tecum erit.</b> Dat enim intervalla et relaxat. <i>Comprehensum, quod cognitum non habet?</i> Virtutibus igitur rectissime mihi videris et ad consuetudinem nostrae orationis vitia posuisse contraria. </p>',
  '1',
  'http://oleaass.com/wp-content/uploads/2014/09/PHP.png',
  NULL,
  NULL,
  'Primum in nostrane potestate est, quid meminerimus? Sint modo partes vitae beatae. Ita fit cum gravior, tum etiam splendidior oratio.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Quamquam id quidem, infinitum est in hac urbe',
  '2016-03-12 16:25:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <code>Ratio quidem vestra sic cogit.</code> Respondent extrema primis, media utrisque, omnia omnibus. <a href=''http://loripsum.net/'' target=''_blank''>Magna laus.</a> <i>Non semper, inquam;</i> </p>

<p>Primum in nostrane potestate est, quid meminerimus? Sint modo partes vitae beatae. Ita fit cum gravior, tum etiam splendidior oratio. <b>Sic consequentibus vestris sublatis prima tolluntur.</b> <i>Audeo dicere, inquit.</i> Hanc quoque iucunditatem, si vis, transfer in animum; At ille pellit, qui permulcet sensum voluptate. Vidit Homerus probari fabulam non posse, si cantiunculis tantus irretitus vir teneretur; </p>

<p><b>Sed ego in hoc resisto;</b> Age sane, inquam. Sed utrum hortandus es nobis, Luci, inquit, an etiam tua sponte propensus es? Haeret in salebra. <b>Sed quod proximum fuit non vidit.</b> Bona autem corporis huic sunt, quod posterius posui, similiora. Nunc omni virtuti vitium contrario nomine opponitur. <b>Negat esse eam, inquit, propter se expetendam.</b> Deinde prima illa, quae in congressu solemus: Quid tu, inquit, huc? </p>

<p><b>Quid nunc honeste dicit?</b> Quamquam id quidem, infinitum est in hac urbe; <i>Ille incendat?</i> Unum nescio, quo modo possit, si luxuriosus sit, finitas cupiditates habere. Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. In qua si nihil est praeter rationem, sit in una virtute finis bonorum; Utilitatis causa amicitia est quaesita. Nam aliquando posse recte fieri dicunt nulla expectata nec quaesita voluptate. </p>

<pre>
Praeterea et appetendi et refugiendi et omnino rerum
gerendarum initia proficiscuntur aut a voluptate aut a
dolore.

Nam et complectitur verbis, quod vult, et dicit plane, quod
intellegam;
</pre>


<ul>
	<li>Habent enim et bene longam et satis litigiosam disputationem.</li>
	<li>Verba tu fingas et ea dicas, quae non sentias?</li>
	<li>Facit igitur Lucius noster prudenter, qui audire de summo bono potissimum velit;</li>
	<li>An nisi populari fama?</li>
	<li>Multa sunt dicta ab antiquis de contemnendis ac despiciendis rebus humanis;</li>
	<li>Quae hic rei publicae vulnera inponebat, eadem ille sanabat.</li>
</ul>


<dl>
	<dt><dfn>Respondeat totidem verbis.</dfn></dt>
	<dd>Intellegi quidem, ut propter aliam quampiam rem, verbi gratia propter voluptatem, nos amemus;</dd>
	<dt><dfn>Non igitur bene.</dfn></dt>
	<dd>Non minor, inquit, voluptas percipitur ex vilissimis rebus quam ex pretiosissimis.</dd>
	<dt><dfn>Pollicetur certe.</dfn></dt>
	<dd>Ad corpus diceres pertinere-, sed ea, quae dixi, ad corpusne refers?</dd>
</dl>


<ol>
	<li>Nam si beatus umquam fuisset, beatam vitam usque ad illum a Cyro extructum rogum pertulisset.</li>
	<li>Idne consensisse de Calatino plurimas gentis arbitramur, primarium populi fuisse, quod praestantissimus fuisset in conficiendis voluptatibus?</li>
	<li>Si est nihil nisi corpus, summa erunt illa: valitudo, vacuitas doloris, pulchritudo, cetera.</li>
	<li>Progredientibus autem aetatibus sensim tardeve potius quasi nosmet ipsos cognoscimus.</li>
</ol>


<p>Duo Reges: constructio interrete. Efficiens dici potest. Vulgo enim dicitur: Iucundi acti labores, nec male Euripidesconcludam, si potero, Latine; <i>Obsecro, inquit, Torquate, haec dicit Epicurus?</i> <mark>Id mihi magnum videtur.</mark> </p>',
  '1',
  'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/MVC-Process.svg/2000px-MVC-Process.svg.png',
  NULL,
  NULL,
  'Duo Reges: constructio interrete. Id est enim, de quo quaerimus. An vero displicuit ea, quae tributa est animi virtutibus tanta praestantia? Sin dicit obscurari quaedam nec apparere, quia valde parva sint, nos quoque concedimus',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Quid de Platone aut de Democrito loquar',
  '2016-03-13 08:29:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Sedulo, inquam, faciam.</a> <b>Videsne, ut haec concinant?</b> Idem etiam dolorem saepe perpetiuntur, ne, si id non faciant, incidant in maiorem. Paulum, cum regem Persem captum adduceret, eodem flumine invectio? </p>

<p><code>Frater et T.</code> Duo Reges: constructio interrete. Id est enim, de quo quaerimus. An vero displicuit ea, quae tributa est animi virtutibus tanta praestantia? Sin dicit obscurari quaedam nec apparere, quia valde parva sint, nos quoque concedimus; <b>Sed ad bona praeterita redeamus.</b> </p>

<p><mark>At iam decimum annum in spelunca iacet.</mark> Comprehensum, quod cognitum non habet? Quid enim ab antiquis ex eo genere, quod ad disserendum valet, praetermissum est? Facit enim ille duo seiuncta ultima bonorum, quae ut essent vera, coniungi debuerunt; Piso igitur hoc modo, vir optimus tuique, ut scis, amantissimus. Quamquam te quidem video minime esse deterritum. <b>Frater et T.</b> Neque enim civitas in seditione beata esse potest nec in discordia dominorum domus; Quo invento omnis ab eo quasi capite de summo bono et malo disputatio ducitur. Sed quid minus probandum quam esse aliquem beatum nec satis beatum? </p>

<ul>
	<li>Non quam nostram quidem, inquit Pomponius iocans;</li>
	<li>Nulla profecto est, quin suam vim retineat a primo ad extremum.</li>
	<li>Nihil acciderat ei, quod nollet, nisi quod anulum, quo delectabatur, in mari abiecerat.</li>
</ul>


<dl>
	<dt><dfn>Magna laus.</dfn></dt>
	<dd>Etenim nec iustitia nec amicitia esse omnino poterunt, nisi ipsae per se expetuntur.</dd>
	<dt><dfn>Si longus, levis.</dfn></dt>
	<dd>Sed tamen enitar et, si minus multa mihi occurrent, non fugiam ista popularia.</dd>
	<dt><dfn>Id mihi magnum videtur.</dfn></dt>
	<dd>Quodcumque in mentem incideret, et quodcumque tamquam occurreret.</dd>
	<dt><dfn>Qui convenit?</dfn></dt>
	<dd>Ergo in gubernando nihil, in officio plurimum interest, quo in genere peccetur.</dd>
</dl>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<p><a href=''http://loripsum.net/'' target=''_blank''>Sed potestne rerum maior esse dissensio?</a> Quid ei reliquisti, nisi te, quoquo modo loqueretur, intellegere, quid diceret? <a href=''http://loripsum.net/'' target=''_blank''>Quippe: habes enim a rhetoribus;</a> Hoc non est positum in nostra actione. Quid ergo? Occultum facinus esse potuerit, gaudebit; <mark>Qualem igitur hominem natura inchoavit?</mark> Sed virtutem ipsam inchoavit, nihil amplius. </p>

<ol>
	<li>Quae animi affectio suum cuique tribuens atque hanc, quam dico.</li>
	<li>Quem Tiberina descensio festo illo die tanto gaudio affecit, quanto L.</li>
	<li>Claudii libidini, qui tum erat summo ne imperio, dederetur.</li>
	<li>Vos autem cum perspicuis dubia debeatis illustrare, dubiis perspicua conamini tollere.</li>
	<li>Praeclare hoc quidem.</li>
</ol>


<pre>
Maximus dolor, inquit, brevis est.

Cupit enim dícere nihil posse ad beatam vitam deesse
sapienti.
</pre>


<h2>Quid dubitas igitur mutare principia naturae?</h2>

<p>Nos commodius agimus. <b>At iam decimum annum in spelunca iacet.</b> Sic vester sapiens magno aliquo emolumento commotus cicuta, si opus erit, dimicabit. Te enim iudicem aequum puto, modo quae dicat ille bene noris. Nihil enim hoc differt. </p>',
  '1',
  'http://camusdevelopment.com/images/img_pub/Lorem%20Ipsum.jpg',
  NULL,
  NULL,
  'Illa videamus, quae a te de amicitia dicta sunt. Si mala non sunt, iacet omnis ratio Peripateticorum. Ad quorum et cognitionem et usum iam corroborati natura ipsa praeeunte deducimur.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Quis istud possit, inquit, negare',
  '2016-03-13 13:29:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Ut aliquid scire se gaudeant?</a> <mark>Quis hoc dicit?</mark> Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt. Bonum incolumis acies: misera caecitas. Nihil enim iam habes, quod ad corpus referas; Habes, inquam, Cato, formam eorum, de quibus loquor, philosophorum. Duo Reges: constructio interrete. Sed quanta sit alias, nunc tantum possitne esse tanta. </p>

<p>Illa videamus, quae a te de amicitia dicta sunt. Si mala non sunt, iacet omnis ratio Peripateticorum. Ad quorum et cognitionem et usum iam corroborati natura ipsa praeeunte deducimur. <a href=''http://loripsum.net/'' target=''_blank''>Satis est ad hoc responsum.</a> <b>Sed ego in hoc resisto;</b> <a href=''http://loripsum.net/'' target=''_blank''>Vide, quaeso, rectumne sit.</a> </p>

<h2>Scientiam pollicentur, quam non erat mirum sapientiae cupido patria esse cariorem.</h2>

<p><a href=''http://loripsum.net/'' target=''_blank''>Haeret in salebra.</a> Tecum optime, deinde etiam cum mediocri amico. Ut non sine causa ex iis memoriae ducta sit disciplina. Sextilio Rufo, cum is rem ad amicos ita deferret, se esse heredem Q. Collige omnia, quae soletis: Praesidium amicorum. Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae. Ad corpus diceres pertinere-, sed ea, quae dixi, ad corpusne refers? Semper enim ita adsumit aliquid, ut ea, quae prima dederit, non deserat. Tria genera bonorum; <b>Non semper, inquam;</b> </p>

<p>Nos paucis ad haec additis finem faciamus aliquando; Duo enim genera quae erant, fecit tria. Tu enim ista lenius, hic Stoicorum more nos vexat. <i>Memini vero, inquam;</i> </p>

<pre>
Nec enim ignoras his istud honestum non summum modo, sed
etiam, ut tu vis, solum bonum videri.

Itaque his sapiens semper vacabit.
</pre>


<ul>
	<li>Qui autem voluptate vitam effici beatam putabit, qui sibi is conveniet, si negabit voluptatem crescere longinquitate?</li>
	<li>In quibus doctissimi illi veteres inesse quiddam caeleste et divinum putaverunt.</li>
	<li>A quibus propter discendi cupiditatem videmus ultimas terras esse peragratas.</li>
	<li>Quorum omnium quae sint notitiae, quae quidem significentur rerum vocabulis, quaeque cuiusque vis et natura sit mox videbimus.</li>
	<li>Solum praeterea formosum, solum liberum, solum civem, stultost;</li>
	<li>Verba tu fingas et ea dicas, quae non sentias?</li>
</ul>


<dl>
	<dt><dfn>Non semper, inquam;</dfn></dt>
	<dd>Ergo adhuc, quantum equidem intellego, causa non videtur fuisse mutandi nominis.</dd>
	<dt><dfn>Erat enim Polemonis.</dfn></dt>
	<dd>Sed haec ab Antiocho, familiari nostro, dicuntur multo melius et fortius, quam a Stasea dicebantur.</dd>
</dl>


<ol>
	<li>Quo modo autem optimum, si bonum praeterea nullum est?</li>
	<li>Est igitur officium eius generis, quod nec in bonis ponatur nec in contrariis.</li>
	<li>Hi curatione adhibita levantur in dies, valet alter plus cotidie, alter videt.</li>
	<li>An quod ita callida est, ut optime possit architectari voluptates?</li>
	<li>Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt.</li>
	<li>Quod est, ut dixi, habere ea, quae secundum naturam sint, vel omnia vel plurima et maxima.</li>
</ol>


<p><b>Id est enim, de quo quaerimus.</b> Obsecro, inquit, Torquate, haec dicit Epicurus? Sed quid attinet de rebus tam apertis plura requirere? Serpere anguiculos, nare anaticulas, evolare merulas, cornibus uti videmus boves, nepas aculeis. Paulum, cum regem Persem captum adduceret, eodem flumine invectio? Prioris generis est docilitas, memoria; </p>',
  '1',
  'http://1.bp.blogspot.com/--Rxqm-7Q73s/UVvDXQsVtrI/AAAAAAAAAAs/-q-dRkMtEr8/s1600/LoremIpsum.png',
  NULL,
  NULL,
  'Quodsi esset in voluptate summum bonum, ut dicitis, optabile esset maxima in voluptate nullo intervallo interiecto dies noctesque versari, cum omnes sensus dulcedine omni quasi perfusi moverentur.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Te enim iudicem aequum puto, modo quae dicat ille bene noris',
  '2016-03-13 15:29:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Piso, familiaris noster, et alia multa et hoc loco Stoicos irridebat: Quid enim? <mark>Non igitur bene.</mark> <a href=''http://loripsum.net/'' target=''_blank''>Eademne, quae restincta siti?</a> Id enim natura desiderat. Duo Reges: constructio interrete. <a href=''http://loripsum.net/'' target=''_blank''>Respondeat totidem verbis.</a> Quare attende, quaeso. </p>

<p>Cupiditates non Epicuri divisione finiebat, sed sua satietate. De quibus cupio scire quid sentias. <a href=''http://loripsum.net/'' target=''_blank''>Efficiens dici potest.</a> Quod autem principium officii quaerunt, melius quam Pyrrho; ALIO MODO. <a href=''http://loripsum.net/'' target=''_blank''>Quonam, inquit, modo?</a> </p>

<pre>
Quodsi esset in voluptate summum bonum, ut dicitis, optabile
esset maxima in voluptate nullo intervallo interiecto dies
noctesque versari, cum omnes sensus dulcedine omni quasi
perfusi moverentur.

Atque ita re simpliciter primo collocata reliqua subtilius
persequentes corporis bona facilem quandam rationem habere
censebant;
</pre>


<h3>Quae similitudo in genere etiam humano apparet.</h3>

<p>Tum Triarius: Posthac quidem, inquit, audacius. Dolere malum est: in crucem qui agitur, beatus esse non potest. Ab his oratores, ab his imperatores ac rerum publicarum principes extiterunt. Item de contrariis, a quibus ad genera formasque generum venerunt. Hoc loco tenere se Triarius non potuit. Ut non sine causa ex iis memoriae ducta sit disciplina. Illi enim inter se dissentiunt. Bonum incolumis acies: misera caecitas. </p>

<p>Cur igitur easdem res, inquam, Peripateticis dicentibus verbum nullum est, quod non intellegatur? Quorum sine causa fieri nihil putandum est. Quae cum essent dicta, discessimus. Non potes, nisi retexueris illa. Sed virtutem ipsam inchoavit, nihil amplius. Habent enim et bene longam et satis litigiosam disputationem. Quod ea non occurrentia fingunt, vincunt Aristonem; <a href=''http://loripsum.net/'' target=''_blank''>Itaque hic ipse iam pridem est reiectus;</a> <code>Proclivi currit oratio.</code> </p>

<dl>
	<dt><dfn>Numquam facies.</dfn></dt>
	<dd>Quem Tiberina descensio festo illo die tanto gaudio affecit, quanto L.</dd>
	<dt><dfn>Numquam facies.</dfn></dt>
	<dd>Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt.</dd>
	<dt><dfn>Haec dicuntur inconstantissime.</dfn></dt>
	<dd>Nihil acciderat ei, quod nollet, nisi quod anulum, quo delectabatur, in mari abiecerat.</dd>
	<dt><dfn>Praeclare hoc quidem.</dfn></dt>
	<dd>Minime id quidem, inquam, alienum, multumque ad ea, quae quaerimus, explicatio tua ista profecerit.</dd>
	<dt><dfn>Restatis igitur vos;</dfn></dt>
	<dd>Hic Speusippus, hic Xenocrates, hic eius auditor Polemo, cuius illa ipsa sessio fuit, quam videmus.</dd>
	<dt><dfn>Facete M.</dfn></dt>
	<dd>Verum hoc loco sumo verbis his eandem certe vim voluptatis Epicurum nosse quam ceteros.</dd>
	<dt><dfn>Sed nimis multa.</dfn></dt>
	<dd>An est aliquid, quod te sua sponte delectet?</dd>
</dl>


<ol>
	<li>Atque haec coniunctio confusioque virtutum tamen a philosophis ratione quadam distinguitur.</li>
	<li>Atque hoc loco similitudines eas, quibus illi uti solent, dissimillimas proferebas.</li>
	<li>Quid turpius quam sapientis vitam ex insipientium sermone pendere?</li>
</ol>


<h2>Utram tandem linguam nescio?</h2>

<p>Qui ita affectus, beatum esse numquam probabis; Sed residamus, inquit, si placet. Sed nimis multa. Ille incendat? Ergo hoc quidem apparet, nos ad agendum esse natos. </p>

<ul>
	<li>Sin laboramus, quis est, qui alienae modum statuat industriae?</li>
	<li>Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae.</li>
	<li>Quae sequuntur igitur?</li>
	<li>Sint ista Graecorum;</li>
	<li>Ita relinquet duas, de quibus etiam atque etiam consideret.</li>
</ul>',
  '1',
  'https://thenewboston.com/photos/users/27/original/f34559fb85ab31961e60e1928bf4e0ca.jpg',
  NULL,
  NULL,
  'Hoc loco tenere se Triarius non potuit. Videamus animi partes, quarum est conspectus illustrior; Teneo, inquit, finem illi videri nihil dolere.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Illa argumenta propria videamus',
  '2016-03-13 17:29:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Numquam facies.</a> Videsne, ut haec concinant? At certe gravius. Quae quo sunt excelsiores, eo dant clariora indicia naturae. <i>Duo Reges: constructio interrete.</i> Itaque ab his ordiamur. </p>

<p>Hoc loco tenere se Triarius non potuit. Videamus animi partes, quarum est conspectus illustrior; Teneo, inquit, finem illi videri nihil dolere. <mark>Istam voluptatem, inquit, Epicurus ignorat?</mark> <mark>Honesta oratio, Socratica, Platonis etiam.</mark> Neque solum ea communia, verum etiam paria esse dixerunt. Nam et complectitur verbis, quod vult, et dicit plane, quod intellegam; Compensabatur, inquit, cum summis doloribus laetitia. </p>

<ol>
	<li>Illa argumenta propria videamus, cur omnia sint paria peccata.</li>
	<li>Suo genere perveniant ad extremum;</li>
	<li>An eum discere ea mavis, quae cum plane perdidiceriti nihil sciat?</li>
	<li>Hinc ceteri particulas arripere conati suam quisque videro voluit afferre sententiam.</li>
</ol>


<ul>
	<li>Ex rebus enim timiditas, non ex vocabulis nascitur.</li>
	<li>Ex quo, id quod omnes expetunt, beate vivendi ratio inveniri et comparari potest.</li>
	<li>Isto modo ne improbos quidem, si essent boni viri.</li>
	<li>Amicitiae vero locus ubi esse potest aut quis amicus esse cuiquam, quem non ipsum amet propter ipsum?</li>
</ul>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<pre>
Sic faciam igitur, inquit: unam rem explicabo, eamque
maximam, de physicis alias, et quidem tibi et declinationem
istam atomorum et magnitudinem solis probabo et Democriti
errata ab Epicuro reprehensa et correcta permulta.

Honestum igitur id intellegimus, quod tale est, ut detracta
omni utilitate sine ullis praemiis fructibusve per se ipsum
possit iure laudari.
</pre>


<p>Animum autem reliquis rebus ita perfecit, ut corpus; <a href=''http://loripsum.net/'' target=''_blank''>Quid adiuvas?</a> Cum id fugiunt, re eadem defendunt, quae Peripatetici, verba. Quos nisi redarguimus, omnis virtus, omne decus, omnis vera laus deserenda est. Tum Lucius: Mihi vero ista valde probata sunt, quod item fratri puto. Sed vobis voluptatum perceptarum recordatio vitam beatam facit, et quidem corpore perceptarum. <a href=''http://loripsum.net/'' target=''_blank''>Restatis igitur vos;</a> <a href=''http://loripsum.net/'' target=''_blank''>Erat enim res aperta.</a> </p>

<dl>
	<dt><dfn>Eademne, quae restincta siti?</dfn></dt>
	<dd>Non dolere, inquam, istud quam vim habeat postea videro;</dd>
	<dt><dfn>Stoicos roga.</dfn></dt>
	<dd>Eaedem enim utilitates poterunt eas labefactare atque pervertere.</dd>
</dl>


<p>Quorum altera prosunt, nocent altera. Satis est ad hoc responsum. Illis videtur, qui illud non dubitant bonum dicere -; Animi enim quoque dolores percipiet omnibus partibus maiores quam corporis. Quos quidem tibi studiose et diligenter tractandos magnopere censeo. Restatis igitur vos; Nam quibus rebus efficiuntur voluptates, eae non sunt in potestate sapientis. Quod autem satis est, eo quicquid accessit, nimium est; <code>Tum ille: Ain tandem?</code> </p>

<h2>Teneo, inquit, finem illi videri nihil dolere.</h2>

<p>Non est ista, inquam, Piso, magna dissensio. <code>Quam nemo umquam voluptatem appellavit, appellat;</code> <a href=''http://loripsum.net/'' target=''_blank''>Quonam, inquit, modo?</a> Ne in odium veniam, si amicum destitero tueri. <a href=''http://loripsum.net/'' target=''_blank''>Quid ait Aristoteles reliquique Platonis alumni?</a> Hoc Hieronymus summum bonum esse dixit. In his igitur partibus duabus nihil erat, quod Zeno commutare gestiret. </p>',
  '1',
  'http://naodev.fr/wp-content/uploads/2015/09/6-30-12_Git.jpg',
  NULL,
  NULL,
  'Traditur, inquit, ab Epicuro ratio neglegendi doloris. Quamquam ab iis philosophiam et omnes ingenuas disciplinas habemus; Quae hic rei publicae vulnera inponebat, eadem ille sanabat.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Restinguet citius si ardentem',
  '2016-03-13 17:39:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Equidem e Cn. Illa videamus, quae a te de amicitia dicta sunt. Sed haec in pueris; <code>Duo Reges: constructio interrete.</code> Ut alios omittam, hunc appello, quem ille unum secutus est. Nondum autem explanatum satis, erat, quid maxime natura vellet. </p>

<pre>
Pomponius Luciusque Cicero, frater noster cognatione
patruelis, amore germanus, constituimus inter nos ut
ambulationem postmeridianam conficeremus in Academia, maxime
quod is locus ab omni turba id temporis vacuus esset.

In contemplatione et cognitione posita rerum, quae quia
deorum erat vitae simillima, sapiente visa est dignissima.
</pre>


<p><b>Et quod est munus, quod opus sapientiae?</b> Ergo adhuc, quantum equidem intellego, causa non videtur fuisse mutandi nominis. <b>Efficiens dici potest.</b> Traditur, inquit, ab Epicuro ratio neglegendi doloris. Quamquam ab iis philosophiam et omnes ingenuas disciplinas habemus; Quae hic rei publicae vulnera inponebat, eadem ille sanabat. <i>An eiusdem modi?</i> At enim, qua in vita est aliquid mali, ea beata esse non potest. <i>Praeclare hoc quidem.</i> <b>Efficiens dici potest.</b> </p>

<h2>Itaque primos congressus copulationesque et consuetudinum instituendarum voluntates fieri propter voluptatem;</h2>

<p><i>Sed ad bona praeterita redeamus.</i> <code>Sed ego in hoc resisto;</code> <a href=''http://loripsum.net/'' target=''_blank''>Istam voluptatem perpetuam quis potest praestare sapienti?</a> Vitae autem degendae ratio maxime quidem illis placuit quieta. </p>

<dl>
	<dt><dfn>Pollicetur certe.</dfn></dt>
	<dd>Sextilio Rufo, cum is rem ad amicos ita deferret, se esse heredem Q.</dd>
	<dt><dfn>Certe non potest.</dfn></dt>
	<dd>Fortitudinis quaedam praecepta sunt ac paene leges, quae effeminari virum vetant in dolore.</dd>
	<dt><dfn>Confecta res esset.</dfn></dt>
	<dd>Ait enim se, si uratur, Quam hoc suave! dicturum.</dd>
	<dt><dfn>Quid vero?</dfn></dt>
	<dd>Nihil minus, contraque illa hereditate dives ob eamque rem laetus.</dd>
	<dt><dfn>Optime, inquam.</dfn></dt>
	<dd>Nam quibus rebus efficiuntur voluptates, eae non sunt in potestate sapientis.</dd>
</dl>


<p><code>Suo genere perveniant ad extremum;</code> Quid autem habent admirationis, cum prope accesseris? Quod totum contra est. <b>Istam voluptatem, inquit, Epicurus ignorat?</b> Etiam beatissimum? Aliud igitur esse censet gaudere, aliud non dolere. </p>

<ul>
	<li>In qua quid est boni praeter summam voluptatem, et eam sempiternam?</li>
	<li>Quia dolori non voluptas contraria est, sed doloris privatio.</li>
	<li>Quarum ambarum rerum cum medicinam pollicetur, luxuriae licentiam pollicetur.</li>
	<li>Ego quoque, inquit, didicerim libentius si quid attuleris, quam te reprehenderim.</li>
	<li>Certe, nisi voluptatem tanti aestimaretis.</li>
</ul>


<p>Et harum quidem rerum facilis est et expedita distinctio. Quid ad utilitatem tantae pecuniae? Sed venio ad inconstantiae crimen, ne saepius dicas me aberrare; Itaque dicunt nec dubitant: mihi sic usus est, tibi ut opus est facto, fac. Qui igitur convenit ab alia voluptate dicere naturam proficisci, in alia summum bonum ponere? Sin tantum modo ad indicia veteris memoriae cognoscenda, curiosorum. <a href=''http://loripsum.net/'' target=''_blank''>Sin aliud quid voles, postea.</a> Aeque enim contingit omnibus fidibus, ut incontentae sint. </p>

<ol>
	<li>Quorum sine causa fieri nihil putandum est.</li>
	<li>Iubet igitur nos Pythius Apollo noscere nosmet ipsos.</li>
	<li>Non minor, inquit, voluptas percipitur ex vilissimis rebus quam ex pretiosissimis.</li>
	<li>Quid, si reviviscant Platonis illi et deinceps qui eorum auditores fuerunt, et tecum ita loquantur?</li>
	<li>Hoc etsi multimodis reprehendi potest, tamen accipio, quod dant.</li>
</ol>',
  '1',
  'https://s3-eu-west-1.amazonaws.com/s3.housseniawriting.com/wp-content/uploads/2015/11/langage-python.jpg',
  '2016-03-13 17:49:48',
  '1',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sic enim censent, oportunitatis esse beate vivere. Quod cum dixissent, ille contra. Non est enim vitium in oratione solum, sed etiam in moribus.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Si voluptas esset bonum',
  '2016-03-13 17:44:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sic enim censent, oportunitatis esse beate vivere. Quod cum dixissent, ille contra. Non est enim vitium in oratione solum, sed etiam in moribus. <mark>Quis est tam dissimile homini.</mark> <code>Erat enim res aperta.</code> </p>

<dl>
	<dt><dfn>Scaevolam M.</dfn></dt>
	<dd>Videamus igitur sententias eorum, tum ad verba redeamus.</dd>
	<dt><dfn>Haeret in salebra.</dfn></dt>
	<dd>Immo istud quidem, inquam, quo loco quidque, nisi iniquum postulo, arbitratu meo.</dd>
</dl>


<p>Duo Reges: constructio interrete. Qui non moveatur et offensione turpitudinis et comprobatione honestatis? Quam ob rem tandem, inquit, non satisfacit? Et homini, qui ceteris animantibus plurimum praestat, praecipue a natura nihil datum esse dicemus? </p>

<ol>
	<li>Quem Tiberina descensio festo illo die tanto gaudio affecit, quanto L.</li>
	<li>Eadem nunc mea adversum te oratio est.</li>
	<li>His enim rebus detractis negat se reperire in asotorum vita quod reprehendat.</li>
	<li>Tibi hoc incredibile, quod beatissimum.</li>
</ol>


<h2>Non quam nostram quidem, inquit Pomponius iocans;</h2>

<p>Non est igitur voluptas bonum. Nam Pyrrho, Aristo, Erillus iam diu abiecti. Quarum ambarum rerum cum medicinam pollicetur, luxuriae licentiam pollicetur. Quae est igitur causa istarum angustiarum? </p>

<p>Verum esto: verbum ipsum voluptatis non habet dignitatem, nec nos fortasse intellegimus. Quaesita enim virtus est, non quae relinqueret naturam, sed quae tueretur. Eorum enim est haec querela, qui sibi cari sunt seseque diligunt. Ergo, inquit, tibi Q. Dic in quovis conventu te omnia facere, ne doleas. Quodsi ipsam honestatem undique pertectam atque absolutam. </p>

<ul>
	<li>Cupit enim dícere nihil posse ad beatam vitam deesse sapienti.</li>
	<li>Certe nihil nisi quod possit ipsum propter se iure laudari.</li>
	<li>Sed quanta sit alias, nunc tantum possitne esse tanta.</li>
	<li>Si quicquam extra virtutem habeatur in bonis.</li>
	<li>Si sapiens, ne tum quidem miser, cum ab Oroete, praetore Darei, in crucem actus est.</li>
</ul>


<pre>
Quod idem Peripatetici non tenent, quibus dicendum est, quae
et honesta actio sit et sine dolore, eam magis esse
expetendam, quam si esset eadem actio cum dolore.

Etenim nec iustitia nec amicitia esse omnino poterunt, nisi
ipsae per se expetuntur.
</pre>


<p>Quamquam haec quidem praeposita recte et reiecta dicere licebit. Si quicquam extra virtutem habeatur in bonis. Efficiens dici potest. Hos contra singulos dici est melius. Bestiarum vero nullum iudicium puto. </p>',
  '1',
  'http://www.revealittech.com/img/large_html.jpg',
  '2016-03-13 18:44:48',
  '1',
  'Quamquam haec quidem praeposita recte et reiecta dicere licebit. Si quicquam extra virtutem habeatur in bonis. Efficiens dici potest.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Altera philosophiae parte',
  '2016-03-13 17:51:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Prioris generis est docilitas, memoria;</a> Sed videbimus. Duarum enim vitarum nobis erunt instituta capienda. </p>

<pre>
Quo posito et omnium adsensu adprobato illud adsumitur, eum,
qui magno sit animo atque forti, omnia, quae cadere in
hominem possint, despicere ac pro nihilo putare.

At ille pellit, qui permulcet sensum voluptate.
</pre>


<p>Hanc ergo intuens debet institutum illud quasi signum absolvere. <b>Duo Reges: constructio interrete.</b> <b>Cur iustitia laudatur?</b> Satis est ad hoc responsum. Ergo opifex plus sibi proponet ad formarum quam civis excellens ad factorum pulchritudinem? Et certamen honestum et disputatio splendida! omnis est enim de virtutis dignitate contentio. </p>

<p>Uterque enim summo bono fruitur, id est voluptate. <i>Quare attende, quaeso.</i> Et harum quidem rerum facilis est et expedita distinctio. Collige omnia, quae soletis: Praesidium amicorum. <code>Tu quidem reddes;</code> </p>

<h2>Isto modo, ne si avia quidem eius nata non esset.</h2>

<p>An quod ita callida est, ut optime possit architectari voluptates? Si verbum sequimur, primum longius verbum praepositum quam bonum. Quae diligentissime contra Aristonem dicuntur a Chryippo. Suam denique cuique naturam esse ad vivendum ducem. Nunc omni virtuti vitium contrario nomine opponitur. Istam voluptatem perpetuam quis potest praestare sapienti? Quid, si etiam iucunda memoria est praeteritorum malorum? Stoicos roga. </p>

<ul>
	<li>Iam illud quale tandem est, bona praeterita non effluere sapienti, mala meminisse non oportere?</li>
	<li>Vos autem cum perspicuis dubia debeatis illustrare, dubiis perspicua conamini tollere.</li>
</ul>

<pre>
<code class="language-c">void anniversaire(struct Personne * p)
{
    p-&gt;age++;
    printf("Joyeux anniversaire %s !", (*p).nom);
}

int main()
{
    struct Personne p;
    p.nom = "Albert";
    p.age = 46;
    anniversaire(&amp;p);
}</code></pre>

<ol>
	<li>Scrupulum, inquam, abeunti;</li>
	<li>Ampulla enim sit necne sit, quis non iure optimo irrideatur, si laboret?</li>
	<li>Nihilne est in his rebus, quod dignum libero aut indignum esse ducamus?</li>
	<li>Ea, quae dialectici nunc tradunt et docent, nonne ab illis instituta sunt aut inventa sunt?</li>
</ol>


<dl>
	<dt><dfn>Pollicetur certe.</dfn></dt>
	<dd>Etenim si delectamur, cum scribimus, quis est tam invidus, qui ab eo nos abducat?</dd>
	<dt><dfn>An potest cupiditas finiri?</dfn></dt>
	<dd>Polemoni et iam ante Aristoteli ea prima visa sunt, quae paulo ante dixi.</dd>
	<dt><dfn>Quo modo?</dfn></dt>
	<dd>Quamquam te quidem video minime esse deterritum.</dd>
	<dt><dfn>Beatum, inquit.</dfn></dt>
	<dd>Nam adhuc, meo fortasse vitio, quid ego quaeram non perspicis.</dd>
</dl>


<p>Serpere anguiculos, nare anaticulas, evolare merulas, cornibus uti videmus boves, nepas aculeis. Theophrasti igitur, inquit, tibi liber ille placet de beata vita? Cui Tubuli nomen odio non est? </p>',
  '1',
  'https://static.oc-static.com/prod/courses/illustrations/illu_ajax-et-l-echange-de-donnees-en-javascript.png',
  NULL,
  NULL,
  'Serpere anguiculos, nare anaticulas, evolare merulas, cornibus uti videmus boves, nepas aculeis. Theophrasti igitur, inquit, tibi liber ille placet de beata vita',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Age sane inquam',
  '2016-03-13 19:44:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <mark>Quod cum dixissent, ille contra.</mark> Nihil ad rem! Ne sit sane; <code>Huius, Lyco, oratione locuples, rebus ipsis ielunior.</code> <a href=''http://loripsum.net/'' target=''_blank''>Avaritiamne minuis?</a> Quonam, inquit, modo? <b>Duo Reges: constructio interrete.</b> </p>

<h2>Quod cum dixissent, ille contra.</h2>

<p>Satisne ergo pudori consulat, si quis sine teste libidini pareat? Nihil ad rem! Ne sit sane; <a href=''http://loripsum.net/'' target=''_blank''>Quid enim?</a> <mark>Nos commodius agimus.</mark> <mark>Non est igitur voluptas bonum.</mark> <i>Si longus, levis;</i> Quorum sine causa fieri nihil putandum est. Propter nos enim illam, non propter eam nosmet ipsos diligimus. </p>

<h3>Quae cum praeponunt, ut sit aliqua rerum selectio, naturam videntur sequi;</h3>

<p>Respondent extrema primis, media utrisque, omnia omnibus. Obsecro, inquit, Torquate, haec dicit Epicurus? Quis hoc dicit? <b>Peccata paria.</b> Si autem id non concedatur, non continuo vita beata tollitur. Quos quidem tibi studiose et diligenter tractandos magnopere censeo. Hoc non est positum in nostra actione. <i>Quae contraria sunt his, malane?</i> Primum divisit ineleganter; </p>

<pre>
Non ergo Epicurus ineruditus, sed ii indocti, qui, quae
pueros non didicisse turpe est, ea putant usque ad
senectutem esse discenda.

Quid dubitas igitur mutare principia naturae?
</pre>

<pre>
<code class="language-c">/* Ceci est un commentaire
   sur deux lignes
   ou plus */</code></pre>

<ul>
	<li>Ergo infelix una molestia, fellx rursus, cum is ipse anulus in praecordiis piscis inventus est?</li>
	<li>Tu enim ista lenius, hic Stoicorum more nos vexat.</li>
	<li>At enim, qua in vita est aliquid mali, ea beata esse non potest.</li>
	<li>Sunt enim quasi prima elementa naturae, quibus ubertas orationis adhiberi vix potest, nec equidem eam cogito consectari.</li>
</ul>


<dl>
	<dt><dfn>Qui convenit?</dfn></dt>
	<dd>Quamquam non negatis nos intellegere quid sit voluptas, sed quid ille dicat.</dd>
	<dt><dfn>Ita credo.</dfn></dt>
	<dd>Quid enim de amicitia statueris utilitatis causa expetenda vides.</dd>
	<dt><dfn>Recte dicis;</dfn></dt>
	<dd>Sin te auctoritas commovebat, nobisne omnibus et Platoni ipsi nescio quem illum anteponebas?</dd>
</dl>


<p><b>Honesta oratio, Socratica, Platonis etiam.</b> Tamen a proposito, inquam, aberramus. Quae enim adhuc protulisti, popularia sunt, ego autem a te elegantiora desidero. <a href=''http://loripsum.net/'' target=''_blank''>Quid enim possumus hoc agere divinius?</a> </p>

<h4>Deque his rebus satis multa in nostris de re publica libris sunt dicta a Laelio.</h4>

<p><i>Minime vero istorum quidem, inquit.</i> <mark>Aliter enim nosmet ipsos nosse non possumus.</mark> Pollicetur certe. Multa sunt dicta ab antiquis de contemnendis ac despiciendis rebus humanis; Aliter enim explicari, quod quaeritur, non potest. Certe nihil nisi quod possit ipsum propter se iure laudari. <code>Sed mehercule pergrata mihi oratio tua.</code> Deinde disputat, quod cuiusque generis animantium statui deceat extremum. </p>

<ol>
	<li>Quis Pullum Numitorium Fregellanum, proditorem, quamquam rei publicae nostrae profuit, non odit?</li>
	<li>Transfer idem ad modestiam vel temperantiam, quae est moderatio cupiditatum rationi oboediens.</li>
	<li>Nonne videmus quanta perturbatio rerum omnium consequatur, quanta confusio?</li>
	<li>In eo enim positum est id, quod dicimus esse expetendum.</li>
	<li>Quod est, ut dixi, habere ea, quae secundum naturam sint, vel omnia vel plurima et maxima.</li>
</ol>',
  '1',
  'http://www.silicon.fr/wp-content/uploads/2012/10/Google-chrome-faille-securite-%C2%A9-drx-Fotolia.com_.jpg',
  NULL,
  NULL,
  'Sapiens autem semper beatus est et est aliquando in dolore; Quae cum dixisset paulumque institisset, Quid est? Suo genere perveniant ad extremum',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Qui-vere falsone',
  '2016-03-13 20:29:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Conferam tecum, quam cuique verso rem subicias; Tanta vis admonitionis inest in locis; In quibus doctissimi illi veteres inesse quiddam caeleste et divinum putaverunt. <a href=''http://loripsum.net/'' target=''_blank''>Duo Reges: constructio interrete.</a> In his igitur partibus duabus nihil erat, quod Zeno commutare gestiret. Et quidem, inquit, vehementer errat; </p>

<ol>
	<li>Quis suae urbis conservatorem Codrum, quis Erechthei filias non maxime laudat?</li>
	<li>An potest, inquit ille, quicquam esse suavius quam nihil dolere?</li>
	<li>In eo enim positum est id, quod dicimus esse expetendum.</li>
</ol>


<p>Sapiens autem semper beatus est et est aliquando in dolore; Quae cum dixisset paulumque institisset, Quid est? Suo genere perveniant ad extremum; <b>Quo tandem modo?</b> </p>

<p>Sedulo, inquam, faciam. Idemne, quod iucunde? <a href=''http://loripsum.net/'' target=''_blank''>Is es profecto tu.</a> Istam voluptatem, inquit, Epicurus ignorat? </p>

<p>Ne in odium veniam, si amicum destitero tueri. Quo modo autem philosophus loquitur? <mark>Nunc vides, quid faciat.</mark> Apparet statim, quae sint officia, quae actiones. <b>Sint ista Graecorum;</b> Multoque hoc melius nos veriusque quam Stoici. Quid enim ab antiquis ex eo genere, quod ad disserendum valet, praetermissum est? Fortasse id optimum, sed ubi illud: Plus semper voluptatis? </p>

<pre>
Huc et illuc, Torquate, vos versetis licet, nihil in hac
praeclara epistula scriptum ab Epicuro congruens et
conveniens decretis eius reperietis.

Ad eos igitur converte te, quaeso.
</pre>


<p>Virtutis, magnitudinis animi, patientiae, fortitudinis fomentis dolor mitigari solet. Quoniam, si dis placet, ab Epicuro loqui discimus. Ergo adhuc, quantum equidem intellego, causa non videtur fuisse mutandi nominis. Saepe ab Aristotele, a Theophrasto mirabiliter est laudata per se ipsa rerum scientia; Quos quidem tibi studiose et diligenter tractandos magnopere censeo. Falli igitur possumus. Urgent tamen et nihil remittunt. Ut nemo dubitet, eorum omnia officia quo spectare, quid sequi, quid fugere debeant? </p>

<dl>
	<dt><dfn>Sed haec omittamus;</dfn></dt>
	<dd>At iam decimum annum in spelunca iacet.</dd>
	<dt><dfn>ALIO MODO.</dfn></dt>
	<dd>Causa autem fuit huc veniendi ut quosdam hinc libros promerem.</dd>
	<dt><dfn>Efficiens dici potest.</dfn></dt>
	<dd>Si enim non fuit eorum iudicii, nihilo magis hoc non addito illud est iudicatum-.</dd>
	<dt><dfn>Non igitur bene.</dfn></dt>
	<dd>Possumusne ergo in vita summum bonum dicere, cum id ne in cena quidem posse videamur?</dd>
</dl>


<ul>
	<li>Nemo nostrum istius generis asotos iucunde putat vivere.</li>
	<li>Atque haec ita iustitiae propria sunt, ut sint virtutum reliquarum communia.</li>
	<li>Itaque dicunt nec dubitant: mihi sic usus est, tibi ut opus est facto, fac.</li>
	<li>Nosti, credo, illud: Nemo pius est, qui pietatem-;</li>
</ul>',
  '1',
  'http://www.campingatlantica.com/uploads/images/Gallery/borne-internet-wifi/internet.png',
  NULL,
  NULL,
  'Suavis laborum est praeteritorum memoria. Stoici autem, quod finem bonorum in una virtute ponunt, similes sunt illorum; Tuo vero id quidem, inquam, arbitratu.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Ergo ita: non posse honeste vivi',
  '2016-03-13 20:51:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Graecum enim hunc versum nostis omnes-: Suavis laborum est praeteritorum memoria. Stoici autem, quod finem bonorum in una virtute ponunt, similes sunt illorum; Tuo vero id quidem, inquam, arbitratu. Duo Reges: constructio interrete. <i>Quare attende, quaeso.</i> Gerendus est mos, modo recte sentiat. <b>Ecce aliud simile dissimile.</b> At quicum ioca seria, ut dicitur, quicum arcana, quicum occulta omnia? Iubet igitur nos Pythius Apollo noscere nosmet ipsos. In qua quid est boni praeter summam voluptatem, et eam sempiternam? </p>

<p><b>Itaque contra est, ac dicitis;</b> Vitiosum est enim in dividendo partem in genere numerare. Ergo infelix una molestia, fellx rursus, cum is ipse anulus in praecordiis piscis inventus est? Sic enim censent, oportunitatis esse beate vivere. </p>

<p><code>Pauca mutat vel plura sane;</code> <i>Praeteritis, inquit, gaudeo.</i> Huius ego nunc auctoritatem sequens idem faciam. <a href=''http://loripsum.net/'' target=''_blank''>Si quidem, inquit, tollerem, sed relinquo.</a> Te enim iudicem aequum puto, modo quae dicat ille bene noris. Nemo nostrum istius generis asotos iucunde putat vivere. </p>

<pre>
Sic igitur in homine perfectio ista in eo potissimum, quod
est optimum, id est in virtute, laudatur.

Tu enim ista lenius, hic Stoicorum more nos vexat.
</pre>


<p>Quo igitur, inquit, modo? Itaque primos congressus copulationesque et consuetudinum instituendarum voluntates fieri propter voluptatem; <i>Quare conare, quaeso.</i> Nam Pyrrho, Aristo, Erillus iam diu abiecti. Idem iste, inquam, de voluptate quid sentit? Quamquam in hac divisione rem ipsam prorsus probo, elegantiam desidero. Ut optime, secundum naturam affectum esse possit. <mark>Tibi hoc incredibile, quod beatissimum.</mark> </p>

<p>In eo enim positum est id, quod dicimus esse expetendum. Sin tantum modo ad indicia veteris memoriae cognoscenda, curiosorum. Non est enim vitium in oratione solum, sed etiam in moribus. Graecum enim hunc versum nostis omnes-: Suavis laborum est praeteritorum memoria. Ut proverbia non nulla veriora sint quam vestra dogmata. <mark>Age, inquies, ista parva sunt.</mark> </p>

<dl>
	<dt><dfn>Sedulo, inquam, faciam.</dfn></dt>
	<dd>In quibus doctissimi illi veteres inesse quiddam caeleste et divinum putaverunt.</dd>
	<dt><dfn>Sint ista Graecorum;</dfn></dt>
	<dd>Est igitur officium eius generis, quod nec in bonis ponatur nec in contrariis.</dd>
	<dt><dfn>Quo tandem modo?</dfn></dt>
	<dd>Sed vos squalidius, illorum vides quam niteat oratio.</dd>
	<dt><dfn>Quid vero?</dfn></dt>
	<dd>Hosne igitur laudas et hanc eorum, inquam, sententiam sequi nos censes oportere?</dd>
	<dt><dfn>Tubulo putas dicere?</dfn></dt>
	<dd>Vulgo enim dicitur: Iucundi acti labores, nec male Euripidesconcludam, si potero, Latine;</dd>
	<dt><dfn>Confecta res esset.</dfn></dt>
	<dd>An ea, quae per vinitorem antea consequebatur, per se ipsa curabit?</dd>
</dl>


<ol>
	<li>Qui autem de summo bono dissentit de tota philosophiae ratione dissentit.</li>
	<li>Atqui haec patefactio quasi rerum opertarum, cum quid quidque sit aperitur, definitio est.</li>
	<li>Nam prius a se poterit quisque discedere quam appetitum earum rerum, quae sibi conducant, amittere.</li>
</ol>


<ul>
	<li>Quamvis enim depravatae non sint, pravae tamen esse possunt.</li>
	<li>Quod est, ut dixi, habere ea, quae secundum naturam sint, vel omnia vel plurima et maxima.</li>
</ul>',
  '1',
  'http://chalifour-assets.s3.amazonaws.com/wp-content/uploads/2014/08/https.jpg',
  NULL,
  NULL,
  'Duo Reges: constructio interrete. Eam stabilem appellas. Beatus autem esse in maximarum rerum timore nemo potest. Quae cum dixisset paulumque institisset, Quid est',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Conclusum est enim contra Cyrenaicos satis acute',
  '2016-03-13 20:59:48',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <b>Vide, quantum, inquam, fallare, Torquate.</b> Isto modo, ne si avia quidem eius nata non esset. Stoici autem, quod finem bonorum in una virtute ponunt, similes sunt illorum; <code>Nos vero, inquit ille;</code> Duo Reges: constructio interrete. Eam stabilem appellas. Beatus autem esse in maximarum rerum timore nemo potest. Quae cum dixisset paulumque institisset, Quid est? </p>

<p>Sed id ne cogitari quidem potest quale sit, ut non repugnet ipsum sibi. <i>Nemo igitur esse beatus potest.</i> <code>Addidisti ad extremum etiam indoctum fuisse.</code> Eaedem res maneant alio modo. <mark>Sed residamus, inquit, si placet.</mark> <b>Non semper, inquam;</b> Quis istud possit, inquit, negare? <a href=''http://loripsum.net/'' target=''_blank''>At eum nihili facit;</a> </p>

<p>Nescio quo modo praetervolavit oratio. Summae mihi videtur inscitiae. Ex rebus enim timiditas, non ex vocabulis nascitur. Negat esse eam, inquit, propter se expetendam. <b>Quippe: habes enim a rhetoribus;</b> Etenim semper illud extra est, quod arte comprehenditur. </p>

<p><a href=''http://loripsum.net/'' target=''_blank''>Si longus, levis dictata sunt.</a> Quaerimus enim finem bonorum. Idem iste, inquam, de voluptate quid sentit? <a href=''http://loripsum.net/'' target=''_blank''>Pauca mutat vel plura sane;</a> Minime vero istorum quidem, inquit. Quae cum magnifice primo dici viderentur, considerata minus probabantur. Sed quanta sit alias, nunc tantum possitne esse tanta. Animum autem reliquis rebus ita perfecit, ut corpus; </p>

<ul>
	<li>Mihi quidem Antiochum, quem audis, satis belle videris attendere.</li>
	<li>Gloriosa ostentatio in constituendo summo bono.</li>
	<li>An dolor longissimus quisque miserrimus, voluptatem non optabiliorem diuturnitas facit?</li>
	<li>Quid, cum fictas fabulas, e quibus utilitas nulla elici potest, cum voluptate legimus?</li>
</ul>

<pre>
<code class="language-html5">&lt;!DOCTYPE html&gt;
&lt;html&gt;
 &lt;head&gt;
  &lt;title&gt;
   Exemple de HTML
  &lt;/title&gt;
 &lt;/head&gt;
 &lt;body&gt;
  Ceci est une phrase avec un &lt;a href="cible.html"&gt;hyperlien&lt;/a&gt;.
  &lt;p&gt;
   Ceci est un paragraphe où il n’y a pas d’hyperlien.
  &lt;/p&gt;
 &lt;/body&gt;
&lt;/html&gt;</code></pre>

<pre>
Possumusne ergo in vita summum bonum dicere, cum id ne in
cena quidem posse videamur?

Tollitur beneficium, tollitur gratia, quae sunt vincla
concordiae.
</pre>


<dl>
	<dt><dfn>Ita prorsus, inquam;</dfn></dt>
	<dd>Quae fere omnia appellantur uno ingenii nomine, easque virtutes qui habent, ingeniosi vocantur.</dd>
	<dt><dfn>Haeret in salebra.</dfn></dt>
	<dd>A primo, ut opinor, animantium ortu petitur origo summi boni.</dd>
	<dt><dfn>Scrupulum, inquam, abeunti;</dfn></dt>
	<dd>Quis istum dolorem timet?</dd>
	<dt><dfn>Audeo dicere, inquit.</dfn></dt>
	<dd>Itaque e contrario moderati aequabilesque habitus, affectiones ususque corporis apti esse ad naturam videntur.</dd>
</dl>


<p>Est enim effectrix multarum et magnarum voluptatum. Omnis enim est natura diligens sui. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum. Neque enim disputari sine reprehensione nec cum iracundia aut pertinacia recte disputari potest. Hoc non est positum in nostra actione. Ita multa dicunt, quae vix intellegam. <a href=''http://loripsum.net/'' target=''_blank''>Vide, quantum, inquam, fallare, Torquate.</a> Quid ait Aristoteles reliquique Platonis alumni? Quae cum dixisset paulumque institisset, Quid est? </p>

<ol>
	<li>Quid ad utilitatem tantae pecuniae?</li>
	<li>Ita enim vivunt quidam, ut eorum vita refellatur oratio.</li>
	<li>Nos paucis ad haec additis finem faciamus aliquando;</li>
	<li>Non est enim vitium in oratione solum, sed etiam in moribus.</li>
</ol>',
  '1',
  'http://images.apple.com/euro/music_alt/home/a/generic/images/social/og.jpg?201602160358',
  NULL,
  NULL,
  'Est enim effectrix multarum et magnarum voluptatum. Omnis enim est natura diligens sui. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum. Neque enim disputari sine reprehensione nec cum iracundia aut pertinacia recte disputari potest.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Nec tamen ille erat sapiens',
  '2016-03-13 21:15:49',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cur tantas regiones barbarorum pedibus obiit, tot maria transmisit? Duo Reges: constructio interrete. Cum id quoque, ut cupiebat, audivisset, evelli iussit eam, qua erat transfixus, hastam. <b>Cur deinde Metrodori liberos commendas?</b> <code>Qui-vere falsone, quaerere mittimus-dicitur oculis se privasse;</code> Non potes, nisi retexueris illa. </p>

<dl>
	<dt><dfn>Tenent mordicus.</dfn></dt>
	<dd>Te ipsum, dignissimum maioribus tuis, voluptasne induxit, ut adolescentulus eriperes P.</dd>
	<dt><dfn>Facete M.</dfn></dt>
	<dd>Quid, si non sensus modo ei sit datus, verum etiam animus hominis?</dd>
	<dt><dfn>Haec dicuntur fortasse ieiunius;</dfn></dt>
	<dd>Quippe: habes enim a rhetoribus;</dd>
</dl>


<p>Ubi ut eam caperet aut quando? <i>Tubulo putas dicere?</i> Quantum Aristoxeni ingenium consumptum videmus in musicis? Ergo ita: non posse honeste vivi, nisi honeste vivatur? Sit, inquam, tam facilis, quam vultis, comparatio voluptatis, quid de dolore dicemus? Beatus autem esse in maximarum rerum timore nemo potest. Tum Quintus: Est plane, Piso, ut dicis, inquit. Aeque enim contingit omnibus fidibus, ut incontentae sint. </p>

<h2>Minime vero, inquit ille, consentit.</h2>

<pre>
<code class="language-html5">&lt;!DOCTYPE html&gt;
&lt;html&gt;
 &lt;head&gt;
  &lt;title&gt;
   Exemple de HTML
  &lt;/title&gt;
 &lt;/head&gt;
 &lt;body&gt;
  Ceci est une phrase avec un &lt;a href="cible.html"&gt;hyperlien&lt;/a&gt;.
  &lt;p&gt;
   Ceci est un paragraphe où il n’y a pas d’hyperlien.
  &lt;/p&gt;
 &lt;/body&gt;
&lt;/html&gt;</code></pre>

<p>Sit, inquam, tam facilis, quam vultis, comparatio voluptatis, quid de dolore dicemus? <mark>Hic ambiguo ludimur.</mark> Quid ei reliquisti, nisi te, quoquo modo loqueretur, intellegere, quid diceret? In quibus doctissimi illi veteres inesse quiddam caeleste et divinum putaverunt. Septem autem illi non suo, sed populorum suffragio omnium nominati sunt. Respondeat totidem verbis. Item de contrariis, a quibus ad genera formasque generum venerunt. <i>Nihilo magis.</i> <i>Scrupulum, inquam, abeunti;</i> Si autem id non concedatur, non continuo vita beata tollitur. </p>

<p><i>Age sane, inquam.</i> Nunc omni virtuti vitium contrario nomine opponitur. Hoc etsi multimodis reprehendi potest, tamen accipio, quod dant. Graecis hoc modicum est: Leonidas, Epaminondas, tres aliqui aut quattuor; Semper enim ita adsumit aliquid, ut ea, quae prima dederit, non deserat. Invidiosum nomen est, infame, suspectum. </p>

<ol>
	<li>Polemoni et iam ante Aristoteli ea prima visa sunt, quae paulo ante dixi.</li>
	<li>Sit enim idem caecus, debilis.</li>
	<li>Minime vero, inquit ille, consentit.</li>
	<li>Nihil acciderat ei, quod nollet, nisi quod anulum, quo delectabatur, in mari abiecerat.</li>
	<li>Ergo id est convenienter naturae vivere, a natura discedere.</li>
	<li>Semper enim ita adsumit aliquid, ut ea, quae prima dederit, non deserat.</li>
</ol>


<pre>
Ergo in bestiis erunt secreta e voluptate humanarum quaedam
simulacra virtutum, in ipsis hominibus virtus nisi
voluptatis causa nulla erit?

Quasi vero, inquit, perpetua oratio rhetorum solum, non
etiam philosophorum sit.
</pre>


<ul>
	<li>Ut necesse sit omnium rerum, quae natura vigeant, similem esse finem, non eundem.</li>
	<li>Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat;</li>
	<li>Non quaeritur autem quid naturae tuae consentaneum sit, sed quid disciplinae.</li>
</ul>


<p>Illum mallem levares, quo optimum atque humanissimum virum, Cn. Istic sum, inquit. At ille pellit, qui permulcet sensum voluptate. Nihil enim iam habes, quod ad corpus referas; Ita relinquet duas, de quibus etiam atque etiam consideret. Non est igitur summum malum dolor. <b>Utilitatis causa amicitia est quaesita.</b> Et quod est munus, quod opus sapientiae? <i>Quis hoc dicit?</i> Nunc haec primum fortasse audientis servire debemus. Bestiarum vero nullum iudicium puto. </p>',
  '1',
  'http://lewebpedagogique.com/presencesenligne/files/2014/10/cloud-computing.png',
  NULL,
  NULL,
  'At iam decimum annum in spelunca iacet.</a> Efficiens dici potest. Multa sunt dicta ab antiquis de contemnendis ac despiciendis rebus humanis; Bestiarum vero nullum iudicium puto. Sed ea mala virtuti magnitudine obruebantur. Sed utrum hortandus es nobis, Luci, inquit.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Itaque ad tempus ad Pisonem omnes',
  '2016-03-13 21:30:10',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et harum quidem rerum facilis est et expedita distinctio. Hoc est non modo cor non habere, sed ne palatum quidem. <b>Quid igitur, inquit, eos responsuros putas?</b> Nam quibus rebus efficiuntur voluptates, eae non sunt in potestate sapientis. <code>Duo Reges: constructio interrete.</code> Suam denique cuique naturam esse ad vivendum ducem. </p>

<p><a href=''http://loripsum.net/'' target=''_blank''>At iam decimum annum in spelunca iacet.</a> Efficiens dici potest. Multa sunt dicta ab antiquis de contemnendis ac despiciendis rebus humanis; Bestiarum vero nullum iudicium puto. Sed ea mala virtuti magnitudine obruebantur. Sed utrum hortandus es nobis, Luci, inquit, an etiam tua sponte propensus es? </p>

<dl>
	<dt><dfn>Quae sequuntur igitur?</dfn></dt>
	<dd>Hic quoque suus est de summoque bono dissentiens dici vere Peripateticus non potest.</dd>
	<dt><dfn>A mene tu?</dfn></dt>
	<dd>At iam decimum annum in spelunca iacet.</dd>
	<dt><dfn>Non semper, inquam;</dfn></dt>
	<dd>At ille non pertimuit saneque fidenter: Istis quidem ipsis verbis, inquit;</dd>
	<dt><dfn>Facete M.</dfn></dt>
	<dd>Varietates autem iniurasque fortunae facile veteres philosophorum praeceptis instituta vita superabat.</dd>
</dl>

<pre>
<code class="language-css">body {
    background-color: #d0e4fe;
}

h1 {
    color: orange;
    text-align: center;
}

p {
    font-family: "Times New Roman";
    font-size: 20px;
}</code></pre>

<ol>
	<li>Itaque sensibus rationem adiunxit et ratione effecta sensus non reliquit.</li>
	<li>Satis est tibi in te, satis in legibus, satis in mediocribus amicitiis praesidii.</li>
	<li>Philosophi autem in suis lectulis plerumque moriuntur.</li>
	<li>Itaque mihi non satis videmini considerare quod iter sit naturae quaeque progressio.</li>
</ol>


<p><b>Quorum altera prosunt, nocent altera.</b> Quid est enim aliud esse versutum? Quamquam ab iis philosophiam et omnes ingenuas disciplinas habemus; Te enim iudicem aequum puto, modo quae dicat ille bene noris. Tuo vero id quidem, inquam, arbitratu. An est aliquid per se ipsum flagitiosum, etiamsi nulla comitetur infamia? Et hunc idem dico, inquieta sed ad virtutes et ad vitia nihil interesse. Quaesita enim virtus est, non quae relinqueret naturam, sed quae tueretur. </p>

<p><i>Ne discipulum abducam, times.</i> Addidisti ad extremum etiam indoctum fuisse. Apud ceteros autem philosophos, qui quaesivit aliquid, tacet; Tu vero, inquam, ducas licet, si sequetur; <code>Quae sequuntur igitur?</code> </p>

<pre>
Nam libero tempore, cum soluta nobis est eligendi optio,
cumque nihil impedit, quo minus id, quod maxime placeat,
facere possimus, omnis voluptas assumenda est, omnis dolor
repellendus.

Satisne igitur videor vim verborum tenere, an sum etiam nunc
vel Graece loqui vel Latine docendus?
</pre>


<ul>
	<li>Qualem igitur hominem natura inchoavit?</li>
	<li>Quae animi affectio suum cuique tribuens atque hanc, quam dico.</li>
	<li>Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt.</li>
</ul>


<p>Restinguet citius, si ardentem acceperit. Duae sunt enim res quoque, ne tu verba solum putes. Si mala non sunt, iacet omnis ratio Peripateticorum. Teneo, inquit, finem illi videri nihil dolere. Aliter homines, aliter philosophos loqui putas oportere? Igitur neque stultorum quisquam beatus neque sapientium non beatus. </p>',
  '1',
  'http://static.commentcamarche.net/www.commentcamarche.net/faq/images/16184-istock-000008756145xsmall.png',
  '2016-03-14 21:30:10',
  '4',
  'Restinguet citius, si ardentem acceperit. Duae sunt enim res quoque, ne tu verba solum putes. Si mala non sunt, iacet omnis ratio Peripateticorum. Teneo, inquit, finem illi videri nihil dolere. Aliter homines, aliter philosophos loqui putas oportere? Igitur neque stultorum quisquam beatus neque sapientium non beatus.',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Itaque mihi non satis videmini considerare quod iter sit naturae',
  '2016-03-13 21:45:44',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nihil enim hoc differt. Aliter enim nosmet ipsos nosse non possumus. <a href=''http://loripsum.net/'' target=''_blank''>Duo Reges: constructio interrete.</a> Nondum autem explanatum satis, erat, quid maxime natura vellet. <a href=''http://loripsum.net/'' target=''_blank''>Frater et T.</a> <code>Quis hoc dicit?</code> Multoque hoc melius nos veriusque quam Stoici. Erit enim mecum, si tecum erit. <code>Haec dicuntur inconstantissime.</code> Illa argumenta propria videamus, cur omnia sint paria peccata. </p>

<p><i>Sed fac ista esse non inportuna;</i> <i>Dicimus aliquem hilare vivere;</i> In qua quid est boni praeter summam voluptatem, et eam sempiternam? Ut proverbia non nulla veriora sint quam vestra dogmata. <a href=''http://loripsum.net/'' target=''_blank''>Aliter enim explicari, quod quaeritur, non potest.</a> </p>

<p>Non igitur bene. Gloriosa ostentatio in constituendo summo bono. Sed mehercule pergrata mihi oratio tua. Tum Quintus: Est plane, Piso, ut dicis, inquit. Primum divisit ineleganter; Beatus autem esse in maximarum rerum timore nemo potest. </p>

<pre>
<code class="language-sql">SELECT nom, service
FROM   employe
WHERE  statut = ''stagiaire''
ORDER  BY nom;</code></pre>

<pre>
Quocirca intellegi necesse est in ipsis rebus, quae
discuntur et cognoscuntur, invitamenta inesse, quibus ad
discendum cognoscendumque moveamur.

Idcirco enim non desideraret, quia, quod dolore caret, id in
voluptate est.
</pre>


<p>Sed tamen enitar et, si minus multa mihi occurrent, non fugiam ista popularia. Quae est igitur causa istarum angustiarum? <b>Ut pulsi recurrant?</b> Quis animo aequo videt eum, quem inpure ac flagitiose putet vivere? Cur iustitia laudatur? Ergo hoc quidem apparet, nos ad agendum esse natos. </p>

<ul>
	<li>At iste non dolendi status non vocatur voluptas.</li>
	<li>Velut ego nunc moveor.</li>
	<li>Quos quidem tibi studiose et diligenter tractandos magnopere censeo.</li>
	<li>Sed fortuna fortis;</li>
	<li>Eodem modo is enim tibi nemo dabit, quod, expetendum sit, id esse laudabile.</li>
</ul>


<dl>
	<dt><dfn>Tubulo putas dicere?</dfn></dt>
	<dd>Gracchum patrem non beatiorem fuisse quam fillum, cum alter stabilire rem publicam studuerit, alter evertere.</dd>
	<dt><dfn>Venit ad extremum;</dfn></dt>
	<dd>Etenim nec iustitia nec amicitia esse omnino poterunt, nisi ipsae per se expetuntur.</dd>
	<dt><dfn>Reguli reiciendam;</dfn></dt>
	<dd>Quaesita enim virtus est, non quae relinqueret naturam, sed quae tueretur.</dd>
	<dt><dfn>Efficiens dici potest.</dfn></dt>
	<dd>Qui autem de summo bono dissentit de tota philosophiae ratione dissentit.</dd>
	<dt><dfn>Peccata paria.</dfn></dt>
	<dd>Et quidem iure fortasse, sed tamen non gravissimum est testimonium multitudinis.</dd>
	<dt><dfn>Beatum, inquit.</dfn></dt>
	<dd>Idemne potest esse dies saepius, qui semel fuit?</dd>
</dl>


<ol>
	<li>Quis est tam dissimile homini.</li>
	<li>Parvi enim primo ortu sic iacent, tamquam omnino sine animo sint.</li>
	<li>Eodem modo is enim tibi nemo dabit, quod, expetendum sit, id esse laudabile.</li>
	<li>Facile pateremur, qui etiam nunc agendi aliquid discendique causa prope contra naturam vígillas suscipere soleamus.</li>
</ol>


<p><i>Primum divisit ineleganter;</i> <a href=''http://loripsum.net/'' target=''_blank''>Haeret in salebra.</a> <a href=''http://loripsum.net/'' target=''_blank''>Istam voluptatem, inquit, Epicurus ignorat?</a> Quamvis enim depravatae non sint, pravae tamen esse possunt. At, si voluptas esset bonum, desideraret. Magni enim aestimabat pecuniam non modo non contra leges, sed etiam legibus partam. Est enim effectrix multarum et magnarum voluptatum. Etsi qui potest intellegi aut cogitari esse aliquod animal, quod se oderit? </p>',
  '1',
  'http://images.cytadel.fr/wp-content/uploads/2015/11/DockerLogo.png',
  '2016-03-15 21:45:44',
  '1',
  'Quamvis enim depravatae non sint, pravae tamen esse possunt. At, si voluptas esset bonum, desideraret. Magni enim aestimabat pecuniam non modo non contra leges, sed etiam legibus partam. Est enim effectrix multarum et magnarum voluptatum. Etsi qui potest intellegi aut cogitari esse aliquod animal, quod se oderit',
  '1',
  '1'
);

INSERT IGNORE INTO `technote`.`technote` (titre, date_creation, contenu, id_auteur, url_image, date_modification, id_modificateur , description, visible, publie) VALUES (
  'Hoc ille tuus non vult omnibusque',
  '2016-03-13 22:03:28',
  '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Omnes enim iucundum motum, quo sensus hilaretur. Et hunc idem dico, inquieta sed ad virtutes et ad vitia nihil interesse. <i>Praeclare hoc quidem.</i> Dicet pro me ipsa virtus nec dubitabit isti vestro beato M. Qua igitur re ab deo vincitur, si aeternitate non vincitur? Duo Reges: constructio interrete. An eum discere ea mavis, quae cum plane perdidiceriti nihil sciat? Sed utrum hortandus es nobis, Luci, inquit, an etiam tua sponte propensus es? <code>Tum Torquatus: Prorsus, inquit, assentior;</code> Neutrum vero, inquit ille. <mark>Paria sunt igitur.</mark> Eadem fortitudinis ratio reperietur. </p>

<pre>
At vero Epicurus una in domo, et ea quidem angusta, quam
magnos quantaque amoris conspiratione consentientis tenuit
amicorum greges! quod fit etiam nunc ab Epicureis.

Etenim nec iustitia nec amicitia esse omnino poterunt, nisi
ipsae per se expetuntur.
</pre>

<pre>
<code class="language-cpp">#include&lt;iostream&gt;

int main()
{
    using std::cout;
    cout &lt;&lt; "Hello, new world!" // std::cout est disponible sans utilisation de std::
         &lt;&lt; std::endl;           // mais pas std::endl
}

void foo()
{
    std::cout &lt;&lt; "Hello, new world!" // std::cout n''est plus disponible sans utilisation de std::
              &lt;&lt; std::endl;
}</code></pre>

<p>Aut, Pylades cum sis, dices te esse Orestem, ut moriare pro amico? Frater et T. <a href=''http://loripsum.net/'' target=''_blank''>Sed fortuna fortis;</a> <b>Restinguet citius, si ardentem acceperit.</b> Hoc Hieronymus summum bonum esse dixit. Si enim ad populum me vocas, eum. <b>Sic enim censent, oportunitatis esse beate vivere.</b> At quanta conantur! Mundum hunc omnem oppidum esse nostrum! Incendi igitur eos, qui audiunt, vides. Quis istud possit, inquit, negare? In qua quid est boni praeter summam voluptatem, et eam sempiternam? </p>

<h2>An potest cupiditas finiri?</h2>

<p>Verum esto: verbum ipsum voluptatis non habet dignitatem, nec nos fortasse intellegimus. <mark>Deprehensus omnem poenam contemnet.</mark> Isto modo, ne si avia quidem eius nata non esset. <a href=''http://loripsum.net/'' target=''_blank''>Hic nihil fuit, quod quaereremus.</a> Indicant pueri, in quibus ut in speculis natura cernitur. Aufert enim sensus actionemque tollit omnem. Quid me istud rogas? Themistocles quidem, cum ei Simonides an quis alius artem memoriae polliceretur, Oblivionis, inquit, mallem. </p>

<p><i>Omnia contraria, quos etiam insanos esse vultis.</i> Ut in voluptate sit, qui epuletur, in dolore, qui torqueatur. Aliena dixit in physicis nec ea ipsa, quae tibi probarentur; Quae sequuntur igitur? </p>

<h3>Fortasse id optimum, sed ubi illud: Plus semper voluptatis?</h3>

<p>Atque ab his initiis profecti omnium virtutum et originem et progressionem persecuti sunt. <a href=''http://loripsum.net/'' target=''_blank''>Certe non potest.</a> Quae quidem sapientes sequuntur duce natura tamquam videntes; <i>Quis est tam dissimile homini.</i> Non risu potius quam oratione eiciendum? Sed residamus, inquit, si placet. Quia nec honesto quic quam honestius nec turpi turpius. Est, ut dicis, inquit; </p>

<ul>
	<li>Scaevola tribunus plebis ferret ad plebem vellentne de ea re quaeri.</li>
	<li>Sic enim censent, oportunitatis esse beate vivere.</li>
	<li>Haec bene dicuntur, nec ego repugno, sed inter sese ipsa pugnant.</li>
	<li>Sed emolumenta communia esse dicuntur, recte autem facta et peccata non habentur communia.</li>
</ul>


<dl>
	<dt><dfn>Ille incendat?</dfn></dt>
	<dd>Tuo vero id quidem, inquam, arbitratu.</dd>
	<dt><dfn>Negare non possum.</dfn></dt>
	<dd>Putabam equidem satis, inquit, me dixisse.</dd>
	<dt><dfn>Moriatur, inquit.</dfn></dt>
	<dd>Nam Pyrrho, Aristo, Erillus iam diu abiecti.</dd>
	<dt><dfn>Avaritiamne minuis?</dfn></dt>
	<dd>Obsecro, inquit, Torquate, haec dicit Epicurus?</dd>
	<dt><dfn>Erat enim Polemonis.</dfn></dt>
	<dd>Atque ab his initiis profecti omnium virtutum et originem et progressionem persecuti sunt.</dd>
	<dt><dfn>Cur iustitia laudatur?</dfn></dt>
	<dd>Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat;</dd>
</dl>


<ol>
	<li>Quod cum accidisset ut alter alterum necopinato videremus, surrexit statim.</li>
	<li>An eiusdem modi?</li>
	<li>Quid nunc honeste dicit?</li>
</ol>',
  '1',
  'https://www.djerfy.com/wp-content/uploads/2016/02/openstack.jpg',
  '2016-03-23 12:03:18',
  '1',
  'Non risu potius quam oratione eiciendum? Sed residamus, inquit, si placet. Quia nec honesto quic quam honestius nec turpi turpius. Est, ut dicis, inquit.',
  '1',
  '1'
);

-- Insertion pour la table mot_cle
INSERT IGNORE INTO `technote`.`mot_cle` (label) VALUES
  ('HTML/CSS'),
  ('JavaScript'),
  ('PHP'),
  ('C'),
  ('C++'),
  ('.NET'),
  ('Java'),
  ('Python'),
  ('BDD'),
  ('Mobile'),
  ('VBA'),
  ('Ruby'),
  ('Windows'),
  ('Linux'),
  ('Mac'),
  ('Graphisme'),
  ('Jeux vidéos'),
  ('Mathématiques'),
  ('Physique'),
  ('Chimie'),
  ('Électronique'),
  ('Sécurité'),
  ('Expressions régulières'),
  ('Sessions'),
  ('Android'),
  ('Mémoire'),
  ('Navigateur')
;

-- Insertion pour la table decrire
INSERT IGNORE INTO `technote`.`decrire` (id_technote, id_mot_cle) VALUES
  ('1', '1'), ('1', '2'), ('1', '3'),
  ('2', '4'), ('2', '5'), ('2', '6'),
  ('5', '17'), ('5', '9'),
  ('10', '14'), ('10', '5'), ('10', '16'),
  ('5', '13'), ('5', '9'),
  ('16', '19'), ('16', '21'), ('16', '8'),
  ('17', '11'),
  ('18', '22'), ('18', '5'), ('18', '6'),
  ('19', '3'), ('19', '13')
;

-- Insertion pour la table commentaire
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('1', 'C''est un commentaire', '1', '2016-04-09 10:03:28', '1', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('2', 'C''est un commentaire imbriqué', '5', '2016-04-09 10:04:28', '1', '1', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('3', 'C''est un autre commentaire', '2', '2016-04-09 10:05:29', '1', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('4', 'C''est un commentaire', '1', '2016-04-09 10:05:30', '3', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('5', 'C''est un commentaire imbriqué', '3', '2016-04-09 10:05:31', '3', '4', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('6', 'C''est un autre commentaire', '5', '2016-04-09 10:05:32', '3', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('7', 'C''est un commentaire', '1', '2016-04-09 10:05:33', '5', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('8', 'C''est un commentaire imbriqué', '2', '2016-04-09 10:05:34', '5', '7', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('9', 'C''est un autre commentaire', '6', '2016-04-09 10:05:38', '5', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('10', 'Superbe technote !', '3', '2016-04-09 10:05:39', '5', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('11', 'Excellent, merci !', '2', '2016-04-09 10:05:40', '5', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('12', 'Superbe technote !', '4', '2016-04-09 10:05:41', '10', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('13', 'Excellent, merci !', '1', '2016-04-09 10:05:43', '10', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('14', 'Superbe technote !', '2', '2016-04-09 10:05:48', '15', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('15', 'Excellent, merci !', '1', '2016-04-09 10:05:50', '15', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('16', 'Superbe technote !', '2', '2016-04-09 10:05:56', '16', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('17', 'Excellent, merci !', '3', '2016-04-09 10:05:59', '16', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('18', 'C''est un commentaire', '1', '2016-04-09 10:06:08', '17', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('19', 'C''est un commentaire imbriqué', '5', '2016-04-09 10:06:12', '17', '18', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('20', 'C''est un autre commentaire', '2', '2016-04-09 10:06:19', '17', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('21', 'C''est un commentaire', '1', '2016-04-09 10:06:28', '18', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('22', 'C''est un commentaire imbriqué', '5', '2016-04-09 10:06:38', '18', '21', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('23', 'C''est un autre commentaire imb', '2', '2016-04-09 10:07:13', '18', '22', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('24', 'Trop cool !', '1', '2016-04-09 10:07:38', '18', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('25', 'Depuis le temps que je voulais une technote sur ça. Juste géniale. Merci', '1', '2016-04-09 10:07:41', '19', NULL, NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('26', 'Trop d''accord avec toi !', '5', '2016-04-09 10:07:48', '19', '25', NULL, NULL, '1');
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('27', 'Fantastique technote !', '2', '2016-04-09 10:07:54', '19', NULL, NULL, NULL, '1');