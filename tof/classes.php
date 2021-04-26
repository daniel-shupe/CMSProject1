<?php
    require '../header.php';
    require '../footer.php';
    require '../menu.php';
    require '../variables.php';
?>

<?php
    display_header("Trials of Faith - Character Classes Overview","An overview of the classes for the Trials of Faith roleplaying game.","../candelas.css");
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<body>
<div class="article">
<h1>Trials of Faith Roleplaying Game Character Classes Overiew</h1>
<p>
    In Trials of Faith, each player can choose from one of ten characters.  While not all are built for front-line combat, all of the clases
    will be useful to the party as they embark on their quest.
</p><hr />
<div class="class_name">Paladin</div>
    <p>
        Paladins are the most devoted of all knights.  They wear heavy armor and focus on protecting their allies in combat.
    </p>
<div class="class_name">Knight</div>
    <p>
        Knights are powerful combatants that are used to heavy armor and are proficient in every type of weapon.
    </p>
<div class="class_name">Merchant</div>
    <p>
        Merchants travel with the army and help the cause by bartering with locals.  In combat, their main strength is bribing enemy soldiers
        to defect.
    </p>
<div class="class_name">Squire</div>
    <p>
        Knights in training, Squires are able to carry a larger bulk than other classes.  While not as powerful as a knight in combat,
        they do have the unique ability to defend allies from arrows with their shield.
    </p>
<div class="class_name">Priest</div>
    <p>
        Priests are devoted to the word of God, and spread His word throughout the land.  In combat, they are able to heal wounded soldiers
        and smite enemy combatants.
    </p>
<div class="class_name">Bard</div>
    <p>
        Bards lift up the spirits of their allies through songs and stories.
    </p>
<div class="class_name">Convert</div>
    <p>
        Former enemies of Christ, Converts have seen the light and aid the cause with unique combat styles.
    </p>
<div class="class_name">Pilgrim</div>
    <p>
        Travelers to the Holy land, Pilgrims are able to blend in with the local population, making them great scouts.
    </p>
<div class="class_name">Soldier</div>
    <p>
        Soldiers make up the majority of the army.  While not as proficient with heavy armor as a Knight, they are a much more agile in combat.
    </p>
<div class="class_name">Archer</div>
    <p>
        Archers prefer to strike from afar with bows and crossbows.
    </p>
</div>
<div class="footer">
<?php
    display_footer("classes.php");
?>
</body>
</html>