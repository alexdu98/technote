USE technote;

# Insertion pour la table groupe
INSERT IGNORE INTO `technote`.`groupe` (id_groupe, libelle, id_groupe_parent) VALUES
  (1, 'Visiteur', NULL),
  (2, 'Membre', 1),
  (3, 'Modérateur', 2),
  (4, 'Administrateur', 3);

#Insertion pour la table droit_groupe
INSERT INTO `technote`.`droit_groupe` (type, cible, id_groupe, autoriser) VALUES
  # Visiteur = droit visiteur (get et autres)
  # ('get', 'technotes', '1', '1'), // Par défaut get accessible pour tout le monde !
  ('get', 'membre', '1', '0'), # Les visiteurs ne peuvent pas voir le profil !
  ('add', 'membre', '1', '1'), # Les visiteurs peuvent s'inscrire !
  ('edit', 'membre', '1', '1'), # Les visiteurs peuvent réinitialiser leur mot de passe
  # Membre = droit visiteur + membre
  ('get', 'membre', '2', '1'), # Les membres peuvent voir leur profil !
  ('add', 'membre', '2', '0'), # Un membre ne peut pas s'inscrire
  ('get', 'connexion', '2', '0'), # Un membre ne peut pas se connecter
  ('drop', 'token', '2', '1'), # Un membre peut supprimer ses token
  ('add', 'technotes', '2', '1'), ('edit', 'technotes', '2', '1'), ('drop', 'technotes', '2', '1'),
  ('add', 'commentaires', '2', '1'), ('edit', 'commentaires', '2', '1'), ('drop', 'commentaires', '2', '1'),
  ('add', 'questions', '2', '1'), ('edit', 'questions', '2', '1'), ('drop', 'questions', '2', '1'),
  ('add', 'reponses', '2', '1'), ('edit', 'reponses', '2', '1'), ('drop', 'reponses', '2', '1'),
  # Membre = droit visiteur + membre
  ('get', 'connexion', '3', '1'), # Un modérateur peut se connecter (administration)
  ('add', 'mots_cles', '3', '1'), ('edit', 'mots_cles', '3', '1'), ('drop', 'mots_cles', '3', '1'),
  # Administrateur = droit visiteur + membre + administrateur
  ('add', 'membre', '4', '1'),
  ('add', 'membres', '4', '1'), ('edit', 'membres', '4', '1'), ('drop', 'membres', '4', '1');

#Insertion pour la table membre
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Alex', 'alexdu98@gmx.fr', '$2y$12$baWf8sziCXcnYb875dCoKe708LxeQI7AQoO8fskrRcQiQO2jyquSC', '4', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('admindemo', 'admindemo@live.fr', '$2y$12$9cyqCXgeeGR7T2zj2SjkduK5bBtDfUehLjBUjO3mvRezcBuF4R3fq', '4', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('modo', 'modo@outlook.fr', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('membre', 'membre@outlook.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Tinnarra', 'Tinnarra@live.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Daewyrr', 'Daewyrr@live.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Neldolen', 'Neldolen@gmail.com', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Swarvard', 'Swarvard@gmail.com', 'mdp', '3', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Legosten', 'Legosten@orange.fr', 'mdp', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Iorakilan', 'Iorakilan@gmx.fr', 'mdp', '2', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Volrod', 'Volrod@gmail.com', 'mdp', '2', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Fategard', 'Fategard@monsite.fr', 'mdp', '2', '1');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('Gasclyr', 'Gasclyr@sfr.fr', 'mdp', '3', '0');

#Insertion pour la table action
INSERT INTO `technote`.`action` (libelle, id_membre) VALUES
  ('Inscription', 1), ('Inscription', 2), ('Inscription', 3),
  ('Inscription', 4), ('Inscription', 5), ('Inscription', 6),
  ('Inscription', 7), ('Inscription', 8), ('Inscription', 9),
  ('Inscription', 10), ('Inscription', 11), ('Inscription', 12);

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
  '2',
  '/assets/images/uploads/bigdata.jpg',
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
  '2',
  '/assets/images/uploads/svn.png',
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
  '3',
  '/assets/images/uploads/symfony.png',
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
  '4',
  '/assets/images/uploads/letsencrypt.jpg',
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
  '8',
  '/assets/images/uploads/lorem.jpg',
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
  '/assets/images/uploads/dd.png',
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
  '11',
  '/assets/images/uploads/mvc.png',
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
  '10',
  '/assets/images/uploads/internet.jpg',
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
  '/assets/images/uploads/PHP.png',
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
  '7',
  '/assets/images/uploads/git.jpg',
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
  '12',
  '/assets/images/uploads/pointInterrogation.png',
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
  '11',
  '/assets/images/uploads/securite.jpg',
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
  '5',
  '/assets/images/uploads/openstack.jpg',
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
  '8',
  '/assets/images/uploads/navigateurs.png',
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
  '/assets/images/uploads/https.jpg',
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
  '8',
  '/assets/images/uploads/ajax.png',
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
  '3',
  '/assets/images/uploads/cloud-computing.png',
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
  '12',
  '/assets/images/uploads/Docker.png',
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
  '9',
  '/assets/images/uploads/html5-css3.jpg',
  '2016-04-23 12:03:18',
  '1',
  'Non risu potius quam oratione eiciendum? Sed residamus, inquit, si placet. Quia nec honesto quic quam honestius nec turpi turpius. Est, ut dicis, inquit.',
  '1',
  '1'
);

-- Insertion pour la table mot_cle
INSERT IGNORE INTO `technote`.`mot_cle` (label, actif) VALUES
  ('HTML/CSS', 1),
  ('JavaScript', 1),
  ('PHP', 1),
  ('C', 1),
  ('C++', 1),
  ('.NET', 1),
  ('Java', 1),
  ('Python', 1),
  ('BDD', 1),
  ('Mobile', 1),
  ('VBA', 1),
  ('Ruby', 1),
  ('Windows', 1),
  ('Linux', 1),
  ('Mac', 1),
  ('Graphisme', 1),
  ('Jeux vidéos', 1),
  ('Mathématiques', 1),
  ('Physique', 1),
  ('Chimie', 1),
  ('Électronique', 1),
  ('Sécurité', 1),
  ('Expressions régulières', 1),
  ('Sessions', 1),
  ('Android', 1),
  ('Mémoire', 1),
  ('Navigateur', 1)
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
INSERT INTO `technote`.`commentaire` (id_commentaire, commentaire, id_auteur, date_creation, id_technote, id_commentaire_parent, date_modification, id_modificateur, visible)
VALUES ('28', 'Il sera supprimer', '2', '2016-04-09 10:08:24', '19', NULL, NULL, NULL, '0');

-- Insertion pour la table question
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (1, 'Lorem ipsum dolor sit amet',
'At hoc in eo M. A mene tu ?
Et quidem, inquit, vehementer errat; Facillimum id quidem est, inquam. Duo Reges: constructio interrete. Sit sane ista voluptas.
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
}</code></pre>'
  , '2016-03-18 14:37:17', 1, 1, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (2, 'Consectetur adipiscing elit in a urna finibus',
'Tamen a proposito, inquam, aberramus. Frater et T. Cave putes quicquam esse verius. Invidiosum nomen est, infame, suspectum. Duo Reges: constructio interrete. Primum quid tu dicis breve?',
'2016-03-18 15:17:47', 1, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (3, 'Donec ultrices dolor sed diam ultrices', 'Memini vero, inquam; Simus igitur contenti his. Duo Reges: constructio interrete. Est, ut dicis, inquit;', '2016-03-18 17:54:07', 2, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (4, 'Proin ac volutpat eros', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. De hominibus dici non necesse est. Falli igitur possumus. <i>At multis se probavit.</i> Quis istud, quaeso, nesciebat? Primum divisit ineleganter; </p>

', '2016-03-18 22:27:11', 3, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (5, 'Cras eget dictum dui', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. An nisi populari fama? Peccata paria.', '2016-03-19 04:57:03', 10, 1, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (6, 'Integer et est tristique nulla pharetra ultrices', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tu quidem reddes; Quid adiuvas? <b>Duo Reges: constructio interrete.</b> <mark>Graccho, eius fere, aequalí?</mark> Quae diligentissime contra Aristonem dicuntur a Chryippo. Stoici scilicet. </p>

<ol>
	<li>Hoc enim identidem dicitis, non intellegere nos quam dicatis voluptatem.</li>
	<li>Ergo, si semel tristior effectus est, hilara vita amissa est?</li>
	<li>Illa tamen simplicia, vestra versuta.</li>
	<li>Ex quo illud efficitur, qui bene cenent omnis libenter cenare, qui libenter, non continuo bene.</li>
</ol>

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


', '2016-03-19 08:07:04', 8, 1, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (7, 'Praesent egestas risus in diam aliquet fringilla', 'Quod cum dixissent, ille contra. Esse enim, nisi eris, non potes.

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
Duo Reges: constructio interrete. Quae sequuntur igitur?', '2016-03-19 09:37:17', 5, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (8, 'Sed nec condimentum ante', 'Esse enim, nisi eris, non potes. Cave putes quicquam esse verius.', '2016-03-19 11:01:28', 12, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (9, 'Etiam arcu mi', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Sed fac ista esse non inportuna;</a> Quam si explicavisset, non tam haesitaret. Nunc de hominis summo bono quaeritur; Nos commodius agimus. <a href=''http://loripsum.net/'' target=''_blank''>Duo Reges: constructio interrete.</a> Sed ad bona praeterita redeamus. </p>

<ul>
	<li>Virtutis, magnitudinis animi, patientiae, fortitudinis fomentis dolor mitigari solet.</li>
	<li>Quid de Platone aut de Democrito loquar?</li>
</ul>


<ol>
	<li>Totum genus hoc Zeno et qui ab eo sunt aut non potuerunt aut noluerunt, certe reliquerunt.</li>
	<li>Quae cum dixisset paulumque institisset, Quid est?</li>
	<li>Non enim, si malum est dolor, carere eo malo satis est ad bene vivendum.</li>
	<li>Nunc ita separantur, ut disiuncta sint, quo nihil potest esse perversius.</li>
</ol>


', '2016-03-19 15:58:18', 4, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (10, 'Fusce tellus ligula, elementum non erat a', 'Iam in altera philosophiae parte. Quantum Aristoxeni ingenium consumptum videmus in musicis?
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
', '2016-03-19 20:20:19', 9, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (11, 'Praesent laoreet nunc risus', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quare attende, quaeso. Ut id aliis narrare gestiant? At certe gravius. Refert tamen, quo modo. </p>

<ul>
	<li>Duo Reges: constructio interrete.</li>
	<li>Non enim, si malum est dolor, carere eo malo satis est ad bene vivendum.</li>
	<li>Primum Theophrasti, Strato, physicum se voluit;</li>
	<li>Hoc est dicere: Non reprehenderem asotos, si non essent asoti.</li>
	<li>Est enim effectrix multarum et magnarum voluptatum.</li>
</ul>


', '2016-03-19 23:56:57', 11, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (12, 'Mollis in, consequat quis', 'Sed haec omittamus; Nullus est igitur cuiusquam dies natalis. Qui convenit? Ut pulsi recurrant?

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
Et quidem, inquit, vehementer errat; Non semper, inquam;', '2016-03-20 12:09:52', 3, 1, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (13, 'Maecenas semper dolor id arcu auctor interdum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Non semper, inquam; Cur iustitia laudatur? <a href=''http://loripsum.net/'' target=''_blank''>Disserendi artem nullam habuit.</a> <a href=''http://loripsum.net/'' target=''_blank''>Traditur, inquit, ab Epicuro ratio neglegendi doloris.</a> <b>Immo alio genere;</b> Duo Reges: constructio interrete. Satis est ad hoc responsum. <b>Nihilo beatiorem esse Metellum quam Regulum.</b> Pugnant Stoici cum Peripateticis. </p>

<pre>
Amicitiae vero locus ubi esse potest aut quis amicus esse
cuiquam, quem non ipsum amet propter ipsum?

Atque ut a corpore ordiar, videsne ut, si quae in membris
prava aut debilitata aut inminuta sint, occultent homines?
</pre>


<dl>
	<dt><dfn>Memini vero, inquam;</dfn></dt>
	<dd>Nam Pyrrho, Aristo, Erillus iam diu abiecti.</dd>
	<dt><dfn>Praeclare hoc quidem.</dfn></dt>
	<dd>Si est nihil nisi corpus, summa erunt illa: valitudo, vacuitas doloris, pulchritudo, cetera.</dd>
	<dt><dfn>Quis enim redargueret?</dfn></dt>
	<dd>Quis istud, quaeso, nesciebat?</dd>
	<dt><dfn>At coluit ipse amicitias.</dfn></dt>
	<dd>Sed tamen intellego quid velit.</dd>
	<dt><dfn>Sed videbimus.</dfn></dt>
	<dd>Sed tamen intellego quid velit.</dd>
</dl>


<ul>
	<li>Apud ceteros autem philosophos, qui quaesivit aliquid, tacet;</li>
	<li>Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat;</li>
</ul>


<ol>
	<li>Terram, mihi crede, ea lanx et maria deprimet.</li>
	<li>Egone non intellego, quid sit don Graece, Latine voluptas?</li>
	<li>Idcirco enim non desideraret, quia, quod dolore caret, id in voluptate est.</li>
	<li>Cupit enim dícere nihil posse ad beatam vitam deesse sapienti.</li>
	<li>Ut alios omittam, hunc appello, quem ille unum secutus est.</li>
</ol>


<blockquote cite=''http://loripsum.net''>
	Aliud igitur esse censet gaudere, aliud non dolere.
</blockquote>


', '2016-03-20 21:36:47', 10, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (14, 'Suspendisse sit amet fringilla', 'Quid vero? Graece donan, Latine voluptatem vocant.

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
Igitur ne dolorem quidem. Stoicos roga.', '2016-03-21 03:03:18', 12, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (15, 'Morbi vestibulum vel neque a laoreet', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Ita prorsus, inquam;</a> Quonam modo? Pollicetur certe. Praeclare hoc quidem. <a href=''http://loripsum.net/'' target=''_blank''>Duo Reges: constructio interrete.</a> Ita multa dicunt, quae vix intellegam. </p>

<ul>
	<li>Immo istud quidem, inquam, quo loco quidque, nisi iniquum postulo, arbitratu meo.</li>
	<li>Nam si +omnino nos+ neglegemus, in Aristonea vitia incidemus et peccata obliviscemurque quae virtuti ipsi principia dederimus;</li>
	<li>Duarum enim vitarum nobis erunt instituta capienda.</li>
	<li>Hoc positum in Phaedro a Platone probavit Epicurus sensitque in omni disputatione id fieri oportere.</li>
	<li>An hoc usque quaque, aliter in vita?</li>
</ul>


<pre>
Negabat igitur ullam esse artem, quae ipsa a se
proficisceretur;

Quamquam id quidem licebit iis existimare, qui legerint.
</pre>


<ol>
	<li>Paulum, cum regem Persem captum adduceret, eodem flumine invectio?</li>
	<li>Nos commodius agimus.</li>
	<li>Nam quibus rebus efficiuntur voluptates, eae non sunt in potestate sapientis.</li>
	<li>Itaque hic ipse iam pridem est reiectus;</li>
</ol>


<blockquote cite=''http://loripsum.net''>
	Quibus natura iure responderit non esse verum aliunde finem beate vivendi, a se principia rei gerendae peti;
</blockquote>


<dl>
	<dt><dfn>Qui convenit?</dfn></dt>
	<dd>Quo modo autem optimum, si bonum praeterea nullum est?</dd>
	<dt><dfn>Tu quidem reddes;</dfn></dt>
	<dd>Sin eam, quam Hieronymus, ne fecisset idem, ut voluptatem illam Aristippi in prima commendatione poneret.</dd>
</dl>


', '2016-03-21 09:05:36', 11, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (16, 'Nulla eu rhoncus tincidunt', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Satis est ad hoc responsum.</a> <b>Sed residamus, inquit, si placet.</b> </p>

<ul>
	<li>Duo Reges: constructio interrete.</li>
	<li>Sed in rebus apertissimis nimium longi sumus.</li>
</ul>


<pre>
An me, inquis, tam amentem putas, ut apud imperitos isto
modo loquar?

Quis contra in illa aetate pudorem, constantiam, etiamsi sua
nihil intersit, non tamen diligat?
</pre>


<ol>
	<li>Quippe, inquieta cum tam docuerim gradus istam rem non habere quam virtutem, in qua sit ipsum etíam beatum.</li>
	<li>Maximus dolor, inquit, brevis est.</li>
	<li>At miser, si in flagitiosa et vitiosa vita afflueret voluptatibus.</li>
	<li>Laelius clamores sofòw ille so lebat Edere compellans gumias ex ordine nostros.</li>
	<li>Nulla erit controversia.</li>
	<li>Octavio fuit, cum illam severitatem in eo filio adhibuit, quem in adoptionem D.</li>
</ol>


<blockquote cite=''http://loripsum.net''>
	Cur igitur easdem res, inquam, Peripateticis dicentibus verbum nullum est, quod non intellegatur?
</blockquote>


<dl>
	<dt><dfn>At certe gravius.</dfn></dt>
	<dd>Quorum altera prosunt, nocent altera.</dd>
	<dt><dfn>Age sane, inquam.</dfn></dt>
	<dd>Quid loquor de nobis, qui ad laudem et ad decus nati, suscepti, instituti sumus?</dd>
	<dt><dfn>Hic ambiguo ludimur.</dfn></dt>
	<dd>Quo invento omnis ab eo quasi capite de summo bono et malo disputatio ducitur.</dd>
	<dt><dfn>Numquam facies.</dfn></dt>
	<dd>Duarum enim vitarum nobis erunt instituta capienda.</dd>
</dl>


', '2016-03-21 20:01:36', 6, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (17, 'Class aptent taciti sociosqu ad litora', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Summae mihi videtur inscitiae. <b>Ego vero isti, inquam, permitto.</b> Hoc non est positum in nostra actione. Equidem e Cn. Illi enim inter se dissentiunt. Duo Reges: constructio interrete. </p>

<dl>
	<dt><dfn>Quis hoc dicit?</dfn></dt>
	<dd>Tum Triarius: Posthac quidem, inquit, audacius.</dd>
	<dt><dfn>Negare non possum.</dfn></dt>
	<dd>Tanti autem aderant vesicae et torminum morbi, ut nihil ad eorum magnitudinem posset accedere.</dd>
	<dt><dfn>Eam stabilem appellas.</dfn></dt>
	<dd>Ego vero volo in virtute vim esse quam maximam;</dd>
	<dt><dfn>Falli igitur possumus.</dfn></dt>
	<dd>Qui potest igitur habitare in beata vita summi mali metus?</dd>
</dl>


<pre>
Nam si dicent ab illis has res esse tractatas, ne ipsos
quidem Graecos est cur tam multos legant, quam legendi sunt.

Licet hic rursus ea commemores, quae optimis verbis ab
Epicuro de laude amicitiae dicta sunt.
</pre>


<blockquote cite=''http://loripsum.net''>
	Omnis sermo elegans sumi potest, tum varietas est tanta artium, ut nemo sine eo instrumento ad ullam rem illustriorem satis ornatus possit accedere.
</blockquote>


<ul>
	<li>Non enim solum Torquatus dixit quid sentiret, sed etiam cur.</li>
	<li>Te ipsum, dignissimum maioribus tuis, voluptasne induxit, ut adolescentulus eriperes P.</li>
</ul>


<ol>
	<li>Sin autem ad animum, falsum est, quod negas animi ullum esse gaudium, quod non referatur ad corpus.</li>
	<li>Commoda autem et incommoda in eo genere sunt, quae praeposita et reiecta diximus;</li>
	<li>Hi curatione adhibita levantur in dies, valet alter plus cotidie, alter videt.</li>
	<li>Multa sunt dicta ab antiquis de contemnendis ac despiciendis rebus humanis;</li>
	<li>Istam voluptatem perpetuam quis potest praestare sapienti?</li>
</ol>


', '2016-03-22 07:55:39', 8, 1, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (18, 'Torquent per conubia nostra', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid enim possumus hoc agere divinius? Quis istud possit, inquit, negare? Quae cum essent dicta, discessimus. Praeteritis, inquit, gaudeo. Quis enim redargueret? Venit ad extremum; </p>

<ul>
	<li>Duo Reges: constructio interrete.</li>
	<li>O magnam vim ingenii causamque iustam, cur nova existeret disciplina! Perge porro.</li>
	<li>Quae similitudo in genere etiam humano apparet.</li>
	<li>Sed est forma eius disciplinae, sicut fere ceterarum, triplex: una pars est naturae, disserendi altera, vivendi tertia.</li>
</ul>


<ol>
	<li>Theophrastum tamen adhibeamus ad pleraque, dum modo plus in virtute teneamus, quam ille tenuit, firmitatis et roboris.</li>
	<li>Collatio igitur ista te nihil iuvat.</li>
	<li>Sed quid minus probandum quam esse aliquem beatum nec satis beatum?</li>
	<li>Si ad corpus pertinentibus, rationes tuas te video compensare cum istis doloribus, non memoriam corpore perceptarum voluptatum;</li>
</ol>


<blockquote cite=''http://loripsum.net''>
	Constituto autem illo, de quo ante diximus, quod honestum esset, id esse solum bonum, intellegi necesse est pluris id, quod honestum sit, aestimandum esse quam illa media, quae ex eo comparentur.
</blockquote>


<pre>
Me ipsum esse dicerem, inquam, nisi mihi viderer habere bene
cognitam voluptatem et satis firme conceptam animo atque
comprehensam.

Nunc ita separantur, ut disiuncta sint, quo nihil potest
esse perversius.
</pre>


<dl>
	<dt><dfn>Quo tandem modo?</dfn></dt>
	<dd>Si mala non sunt, iacet omnis ratio Peripateticorum.</dd>
	<dt><dfn>Ut pulsi recurrant?</dfn></dt>
	<dd>Virtutibus igitur rectissime mihi videris et ad consuetudinem nostrae orationis vitia posuisse contraria.</dd>
	<dt><dfn>Sed haec omittamus;</dfn></dt>
	<dd>Nam Metrodorum non puto ipsum professum, sed, cum appellaretur ab Epicuro, repudiare tantum beneficium noluisse;</dd>
	<dt><dfn>Magna laus.</dfn></dt>
	<dd>Sed quid attinet de rebus tam apertis plura requirere?</dd>
	<dt><dfn>Quis enim redargueret?</dfn></dt>
	<dd>Aliena dixit in physicis nec ea ipsa, quae tibi probarentur;</dd>
</dl>


', '2016-03-22 17:00:30', 9, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (19, 'Facilisis in ex id mollis', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href=''http://loripsum.net/'' target=''_blank''>Qui est in parvis malis.</a> Multoque hoc melius nos veriusque quam Stoici. <mark>Huius, Lyco, oratione locuples, rebus ipsis ielunior.</mark> <a href=''http://loripsum.net/'' target=''_blank''>Non quam nostram quidem, inquit Pomponius iocans;</a> Sed virtutem ipsam inchoavit, nihil amplius. Duo Reges: constructio interrete. <i>Idem iste, inquam, de voluptate quid sentit?</i> </p>

<ol>
	<li>Ut scias me intellegere, primum idem esse dico voluptatem, quod ille don.</li>
	<li>Nec enim, dum metuit, iustus est, et certe, si metuere destiterit, non erit;</li>
	<li>Partim cursu et peragratione laetantur, congregatione aliae coetum quodam modo civitatis imitantur;</li>
	<li>Dic in quovis conventu te omnia facere, ne doleas.</li>
	<li>Si quicquam extra virtutem habeatur in bonis.</li>
	<li>Ita ceterorum sententiis semotis relinquitur non mihi cum Torquato, sed virtuti cum voluptate certatio.</li>
</ol>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<dl>
	<dt><dfn>Poterat autem inpune;</dfn></dt>
	<dd>Pudebit te, inquam, illius tabulae, quam Cleanthes sane commode verbis depingere solebat.</dd>
	<dt><dfn>Haec dicuntur inconstantissime.</dfn></dt>
	<dd>Unum nescio, quo modo possit, si luxuriosus sit, finitas cupiditates habere.</dd>
	<dt><dfn>Nos commodius agimus.</dfn></dt>
	<dd>At multis se probavit.</dd>
</dl>


<ul>
	<li>Expressa vero in iis aetatibus, quae iam confirmatae sunt.</li>
	<li>Non dolere, inquam, istud quam vim habeat postea videro;</li>
	<li>Indicant pueri, in quibus ut in speculis natura cernitur.</li>
	<li>Sin autem eos non probabat, quid attinuit cum iis, quibuscum re concinebat, verbis discrepare?</li>
</ul>


<blockquote cite=''http://loripsum.net''>
	Concede nihil esse bonum, nisi quod bonestum sit: concedendum est in virtute esse positam beatam vitam vide rursus retro: dato hoc dandum erit illud.
</blockquote>


<pre>
Sed nonne merninisti licere mihi ista probare, quae sunt a
te dicta?

Quae in controversiam veniunt, de iis, si placet,
disseramus.
</pre>


', '2016-03-22 19:35:06', 2, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (20, 'Hendrerit sem sed fermentum condimentum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid enim? <a href=''http://loripsum.net/'' target=''_blank''>Cur deinde Metrodori liberos commendas?</a> Duo Reges: constructio interrete. Nescio quo modo praetervolavit oratio. Quodsi ipsam honestatem undique pertectam atque absolutam. <a href=''http://loripsum.net/'' target=''_blank''>Omnes enim iucundum motum, quo sensus hilaretur.</a> </p>

<ul>
	<li>Huius, Lyco, oratione locuples, rebus ipsis ielunior.</li>
	<li>Superiores tres erant, quae esse possent, quarum est una sola defensa, eaque vehementer.</li>
	<li>Ut in voluptate sit, qui epuletur, in dolore, qui torqueatur.</li>
	<li>In primo enim ortu inest teneritas ac mollitia quaedam, ut nec res videre optimas nec agere possint.</li>
	<li>Ita multo sanguine profuso in laetitia et in victoria est mortuus.</li>
	<li>Cur igitur, cum de re conveniat, non malumus usitate loqui?</li>
</ul>


<dl>
	<dt><dfn>Sint ista Graecorum;</dfn></dt>
	<dd>Pudebit te, inquam, illius tabulae, quam Cleanthes sane commode verbis depingere solebat.</dd>
	<dt><dfn>Quis enim redargueret?</dfn></dt>
	<dd>Atque ab his initiis profecti omnium virtutum et originem et progressionem persecuti sunt.</dd>
	<dt><dfn>Scaevolam M.</dfn></dt>
	<dd>Non est igitur summum malum dolor.</dd>
	<dt><dfn>Paria sunt igitur.</dfn></dt>
	<dd>Ea, quae dialectici nunc tradunt et docent, nonne ab illis instituta sunt aut inventa sunt?</dd>
	<dt><dfn>Quonam, inquit, modo?</dfn></dt>
	<dd>Quid autem habent admirationis, cum prope accesseris?</dd>
	<dt><dfn>Stoici scilicet.</dfn></dt>
	<dd>Numquam facies.</dd>
</dl>


<ol>
	<li>At quicum ioca seria, ut dicitur, quicum arcana, quicum occulta omnia?</li>
	<li>Quae similitudo in genere etiam humano apparet.</li>
	<li>Tu vero, inquam, ducas licet, si sequetur;</li>
	<li>Nosti, credo, illud: Nemo pius est, qui pietatem-;</li>
</ol>


<blockquote cite=''http://loripsum.net''>
	An, si id probas, fieri ita posse negas, ut ii, qui virtutis compotes sint, etiam malis quibusdam affecti beati sint?
</blockquote>


<pre>
Is hoc melior, quam Pyrrho, quod aliquod genus appetendi
dedit, deterior quam ceteri, quod penitus a natura recessit.

Quid in isto egregio tuo officio et tanta fide-sic enim
existimo-ad corpus refers?
</pre>


', '2016-03-24 10:55:31', 4, 0, NULL, NULL, 1);
INSERT INTO `technote`.`question` (id_question, titre, question, date_question, id_auteur, resolu, date_modification, id_modificateur, visible) VALUES (21, 'Phasellus eleifend tempor tortor', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sullae consulatum? <mark>Non est igitur summum malum dolor.</mark> <code>Duo Reges: constructio interrete.</code> Quid iudicant sensus? Tubulo putas dicere? </p>

<pre>
Primum enim, si vera sunt ea, quorum recordatione te gaudere
dicis, hoc est, si vera sunt tua scripta et inventa, gaudere
non potes.

Epicurus autem cum in prima commendatione voluptatem
dixisset, si eam, quam Aristippus, idem tenere debuit
ultimum bonorum, quod ille;
</pre>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<ul>
	<li>Ad corpus diceres pertinere-, sed ea, quae dixi, ad corpusne refers?</li>
	<li>Summus dolor plures dies manere non potest?</li>
	<li>Duarum enim vitarum nobis erunt instituta capienda.</li>
	<li>Idemque diviserunt naturam hominis in animum et corpus.</li>
	<li>Res enim concurrent contrariae.</li>
	<li>Vitiosum est enim in dividendo partem in genere numerare.</li>
</ul>


<blockquote cite=''http://loripsum.net''>
	Alia quaedam dicent, credo, magna antiquorum esse peccata, quae ille veri investigandi cupidus nullo modo ferre potuerit.
</blockquote>


<dl>
	<dt><dfn>Hunc vos beatum;</dfn></dt>
	<dd>Quis contra in illa aetate pudorem, constantiam, etiamsi sua nihil intersit, non tamen diligat?</dd>
	<dt><dfn>Quae sequuntur igitur?</dfn></dt>
	<dd>Quod ea non occurrentia fingunt, vincunt Aristonem;</dd>
	<dt><dfn>Audeo dicere, inquit.</dfn></dt>
	<dd>Sed venio ad inconstantiae crimen, ne saepius dicas me aberrare;</dd>
</dl>


<ol>
	<li>Sed ille, ut dixi, vitiose.</li>
	<li>Hoc est non modo cor non habere, sed ne palatum quidem.</li>
	<li>Nullus est igitur cuiusquam dies natalis.</li>
	<li>Nonne videmus quanta perturbatio rerum omnium consequatur, quanta confusio?</li>
	<li>Qui enim voluptatem ipsam contemnunt, iis licet dicere se acupenserem maenae non anteponere.</li>
</ol>


', '2016-03-24 18:45:16', 5, 1, NULL, NULL, 1);

-- Insertion pour la table clarifier
INSERT IGNORE INTO `technote`.`clarifier` (id_question, id_mot_cle) VALUES
  ('1', '1'), ('1', '12'),
  ('2', '4'), ('2', '7'), ('2', '16'),
  ('5', '17'), ('5', '13'),
  ('10', '15'), ('10', '16'),
  ('5', '11'), ('5', '9'),
  ('16', '14'), ('16', '11'),
  ('17', '12'),
  ('18', '21'), ('18', '4'), ('18', '5'),
  ('19', '4'), ('19', '14'),
  ('20', '11'),
  ('21', '1')
;

-- Insertion pour la table reponse
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (1, 'Et prima post Osdroenam quam, ut dictum est, ab hac descriptione discrevimus,
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
Commagena, nunc Euphratensis, clementer adsurgit, Hierapoli, vetere Nino et Samosata civitatibus amplis inlustris.', '2016-03-28 08:15:16', '1', NULL, '1', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (2, '<p>Cur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. <b>Lorem ipsum dolor sit amet, consectetur adipiscing elit</b>. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>', '2016-03-28 10:16:18', '1', NULL, '2', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (3, '<p>Piscing elit. Sit enim idem caecus, debilis. Quonam modo? Id Sextilius factum negabat. Si longus, levis. Duo Reges: constructio interrete. Sed quot homines, tot sententiae; </p>

<p>Sumenda potius quam expetenda. Id enim natura desiderat. Sed ad bona praeterita redeamus. Quid ergo? </p>

', '2016-03-28 12:41:43', '2', NULL, '4', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (4, '<p>Quidem reddes; Hoc simile tandem est? Res enim concurrent contrariae. Nos commodius agimus. Nobis aliter videtur, recte secusne, postea; </p>
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
<p>Refert tamen, quo modo. Duo Reges: constructio interrete. Tenent mordicus. Odium autem et invidiam facile vitabis. Utilitatis causa amicitia est quaesita. Immo alio genere; </p>

', '2016-03-28 15:53:34', '4', NULL, '8', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (5, '<p>Elit. Tanta vis admonitionis inest in locis; <i>Contemnit enim disserendi elegantiam, confuse loquitur.</i> </p>

<p><i>Quid adiuvas?</i> Polycratem Samium felicem appellabant. Duo Reges: constructio interrete. Scaevolam M. </p>

', '2016-03-28 19:11:19', '4', '4', '3', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (6, '<p>Tamen a proposito, inquam, aberramus. Quonam, inquit, modo? Ea possunt paria non esse. Sint modo partes vitae beatae. Certe, nisi voluptatem tanti aestimaretis. </p>
<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>
<p>Duo Reges: constructio interrete. Tubulo putas dicere? Sed ille, ut dixi, vitiose. Vide, quantum, inquam, fallare, Torquate. Cur iustitia laudatur? A mene tu? </p>

', '2016-03-28 19:22:56', '7', NULL, '10', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (7, '<p>Tollenda est atque extrahenda radicitus. Efficiens dici potest. Equidem e Cn. Sequitur disserendi ratio cognitioque naturae; </p>

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
<p>Nihil enim hoc differt. Duo Reges: constructio interrete. Simus igitur contenti his. Verum hoc idem saepe faciamus. </p>

', '2016-03-28 20:36:46', '10', NULL, '12', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (8, 'Quod cum dixissent, ille contra. Cur haec eadem Democritus? Nos commodius agimus. Frater et T. Quibus ego vehementer assentior.

Duo Reges: constructio interrete. Cur id non ita fit?', '2016-03-28 21:55:34', '10', NULL, '6', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (9, '<p><b>Idem iste, inquam, de voluptate quid sentit?</b> Confecta res esset. <i>Equidem e Cn.</i> Graece donan, Latine voluptatem vocant. Cur deinde Metrodori liberos commendas? Duo Reges: constructio interrete. Sed tamen intellego quid velit. Sin aliud quid voles, postea. </p>

<p>Frater et T. Prioris generis est docilitas, memoria; Sed quot homines, tot sententiae; Nulla erit controversia. Sed videbimus. Quid Zeno? </p>

', '2016-03-28 23:08:06', '10', '8', '1', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (10, '<p>Lorem ipsum adipiscing elit. <i>At hoc in eo M.</i> <i>Duo Reges: constructio interrete.</i> Quo tandem modo? Tum mihi Piso: Quid ergo? Peccata paria. </p>

<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>

<p>Prioris generis est docilitas, memoria; <b>Simus igitur contenti his.</b> Si id dicis, vicimus. Egone quaeris, inquit, quid sentiam? </p>

', '2016-03-29 03:51:45', '14', NULL, '3', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (11, '<p>Sit amet, consectetur adipiscing elit. <i>Res enim concurrent contrariae.</i> Mihi enim satis est, ipsis non satis. Sedulo, inquam, faciam. Id Sextilius factum negabat. <i>Si longus, levis.</i> <i>Sed ea mala virtuti magnitudine obruebantur.</i> </p>

<p>Duo Reges: constructio interrete. <i>Perge porro;</i> Quis hoc dicit? Sullae consulatum? Non semper, inquam; </p>

', '2016-03-29 07:59:56', '14', '10', '1', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (12, '<p>Tetur adipiscing elit. Praeteritis, inquit, gaudeo. Bonum integritas corporis: misera debilitas. Si longus, levis dictata sunt. Quid Zeno? At eum nihili facit; Aliter enim explicari, quod quaeritur, non potest. </p>

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
<p>Tum Torquatus: Prorsus, inquit, assentior; Duo Reges: constructio interrete. Eam stabilem appellas. Eadem nunc mea adversum te oratio est. <mark>Quod equidem non reprehendo;</mark> Urgent tamen et nihil remittunt. </p>

', '2016-03-29 08:02:31', '18', NULL, '11', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (13, '<p><mark>Qualem igitur hominem natura inchoavit?</mark> Quid igitur, inquit, eos responsuros putas? Zenonis est, inquam, hoc Stoici. Quis hoc dicit? <i>Duo Reges: constructio interrete.</i> Certe, nisi voluptatem tanti aestimaretis. Haec dicuntur inconstantissime. Utilitatis causa amicitia est quaesita. </p>

<p><i>Cyrenaici quidem non recusant;</i> Summae mihi videtur inscitiae. <mark>Cur id non ita fit?</mark> Nihil sane. Prodest, inquit, mihi eo esse animo. Praeteritis, inquit, gaudeo. Est, ut dicis, inquam. Hic ambiguo ludimur. </p>

', '2016-03-29 12:00:01', '18', NULL, '1', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (14, '<p>Amet, consectetur adipiscing elit. At coluit ipse amicitias. Quaerimus enim finem bonorum. Est, ut dicis, inquit; Frater et T. Collatio igitur ista te nihil iuvat. Quid ergo hoc loco intellegit honestum? </p>

<p>Equidem, sed audistine modo de Carneade? <b>Refert tamen, quo modo.</b> Iam contemni non poteris. Et ille ridens: Video, inquit, quid agas; Igitur ne dolorem quidem. </p>

<p>Duo Reges: constructio interrete. Quid de Pythagora? </p>

', '2016-03-29 13:08:09', '19', NULL, '6', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (15, '<p>Adipiscing elit. Duo Reges: constructio interrete. Primum in nostrane potestate est, quid meminerimus? Sed residamus, inquit, si placet. Proclivi currit oratio. An hoc usque quaque, aliter in vita? Sed nunc, quod agimus; Collige omnia, quae soletis: Praesidium amicorum. </p>

<p>Quantum Aristoxeni ingenium consumptum videmus in musicis? Haeret in salebra. Que Manilium, ab iisque M. Quod quidem iam fit etiam in Academia. Fortemne possumus dicere eundem illum Torquatum? Rationis enim perfectio est virtus; </p>

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
<p>Bonum patria: miserum exilium. Cave putes quicquam esse verius. Efficiens dici potest. <i>Poterat autem inpune;</i> At certe gravius. Tollenda est atque extrahenda radicitus. Qui est in parvis malis. </p>

', '2016-03-29 14:05:18', '20', NULL, '7', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (16, '<p>Lorem consectetur adipiscing elit. <mark>Tubulo putas dicere?</mark> Negare non possum. Falli igitur possumus. <b>Non potes, nisi retexueris illa.</b> Qualem igitur hominem natura inchoavit? </p>

<p>Duo Reges: constructio interrete. <b>Tu quidem reddes;</b> Si longus, levis dictata sunt. Magna laus. Eaedem res maneant alio modo. <mark>Non igitur bene.</mark> <b>Hic nihil fuit, quod quaereremus.</b> </p>

', '2016-03-29 18:15:00', '20', '15', '2', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (17, '<p>Dolor sit amet, consectetur adipiscing elit. Cur haec eadem Democritus? Qua tu etiam inprudens utebare non numquam. Bonum patria: miserum exilium. <b>Duo Reges: constructio interrete.</b> Immo videri fortasse. Respondeat totidem verbis. </p>
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
<p>Expectoque quid ad id, quod quaerebam, respondeas. Idemne, quod iucunde? Nihil illinc huc pervenit. <mark>Tollitur beneficium, tollitur gratia, quae sunt vincla concordiae.</mark> Scrupulum, inquam, abeunti; </p>

', '2016-03-29 18:20:54', '20', NULL, '8', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (18, '<p>Consectetur adipiscing elit. Sin aliud quid voles, postea. <i>Quis enim redargueret?</i> </p>

<p>Tu quidem reddes; Nunc agendum est subtilius. </p>

', '2016-03-29 19:09:21', '21', NULL, '9', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (19, '<p><b>Ergo, inquit, tibi Q.</b> Sed tamen intellego quid velit. Tria genera bonorum; Sequitur disserendi ratio cognitioque naturae; </p>

<p><mark>Rationis enim perfectio est virtus;</mark> At ille pellit, qui permulcet sensum voluptate. Esse enim, nisi eris, non potes. Duo Reges: constructio interrete. Quaerimus enim finem bonorum. Que Manilium, ab iisque M. Quod equidem non reprehendo; Quid enim possumus hoc agere divinius? </p>

', '2016-03-29 19:59:48', '21', NULL, '5', NULL, NULL, '1');
INSERT INTO `technote`.`reponse` (id_reponse, reponse, date_reponse, id_question, id_reponse_parent, id_auteur, date_modification, id_modificateur, visible) VALUES (20, '<p>Sed fortuna fortis; Qui convenit? Quare attende, quaeso. <mark>Id est enim, de quo quaerimus.</mark> Duo Reges: constructio interrete. </p>
<pre><code class="language-php-brief">// la fonction strtolower renvoie en minuscules la chaîne de caractères passée en paramètre
$lang = strtolower($_POST[''lang'']);

if ($lang === ''fr'')
    echo ''Vous parlez français !'';
elseif ($lang === ''en'')
    echo ''You speak English!'';
else
    echo ''Je ne vois pas quelle est votre langue !'';
</code></pre>
<p>Memini vero, inquam; Si quae forte-possumus. Sed mehercule pergrata mihi oratio tua. Contemnit enim disserendi elegantiam, confuse loquitur. </p>

', '2016-03-29 20:22:33', '21', '19', '4', NULL, NULL, '1');