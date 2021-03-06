<html lang="en">
<head>
    <?php include 'includes/header.php' ?>

    <title>Improving the Random Bot</title>

    <link href="lib/bootstrap.min.css" rel="stylesheet">
    <link href="style/general.css" rel="stylesheet">
    <link href="style/learn.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <div class="row">
            <?php include 'includes/learn_sidebar.php' ?>
            <div class="col-sm-9">
                <h1>Improving the Random Bot</h1>
                <p>In this tutorial, we'll go through the code that powers the random bot and add a couple heuristics to it. This will hopefully help you fully understand Halite and set you on your way to leaderboard domination.</p>

                <p>The code in this tutorial can be found at the following links for <a href="https://gist.github.com/JCGrant/5ea767bae8a725f738d75649e5f2c91a">Python</a>, <a href="https://gist.github.com/Sydriax/a2b8b88c940abe8f346df62a77e23441">Java</a>, and <a href="https://gist.github.com/Sydriax/3aaabd3ecbc03ff997c720e7c5840a9a">C++</a>.</p>
                <h3>Prerequisites</h3>
                <p>Make sure that you have read <a href="https://halite.io/basics_intro_halite.php">Introducing Halite</a> and followed the setup procedures described there.</p>
                <p>Now open up the MyBot file in your favorite editor and let's get started!</p>

                <h3>Import Considerations</h3>
                <p>When writing a halite bot, be sure to stay away from functions like <code>System.out.print</code>, <code>cout</code>, <code>print</code>, etc. Bots use stdout and stdin to communicate with the game environment. You will be ejected from a game of Halite if you print debugging info to stdout. Instead, print to a log file.</p>

                <h3>A Look At the Random Bot</h3>
                <p>Now that you know how the game works, how do the two random starter bots work? How does one code a Halite bot? Here is the source from the main file of our python starter bot:</p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-file="Random.py"></span>
                <p>Let's walk through it line by line.</p>

                <p>First we import a couple of helper files that are included in the starter packages:</p>

                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-hide-footer="true" data-gist-line="3-4" data-gist-file="Random.py"></span>

                <p>Then we get our ID (each player has a unique identifier that is associated with their pieces) and the game initial map from the environment.</p>
                <p>We send back the name of our bot. This is used in game replays.</p>

                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-hide-footer="true" data-gist-line="6-7" data-gist-file="Random.py"></span>

                <p>Now we start our game loop. Each frame let's initialize a list of moves and get the current map:</p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-hide-footer="true" data-gist-line="9-11" data-gist-file="Random.py"></span>

                <p>Let's cycle through all of the pieces on the map. If a piece is owned by us, let's order it to move in a random direction.</p>

                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-hide-footer="true" data-gist-line="12-16" data-gist-file="Random.py"></span>

                <p>Finally, let's send all of our moves to the environment:</p>

                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-hide-footer="true" data-gist-line="17" data-gist-file="Random.py"></span>

                <p>And that's random bot!</p>

                <h3>Utilizing Our Production</h3>

                <p>From the rules outlined in <a href="https://halite.io/basics_intro_halite.php">Introducing Halite</a>, we know that when a piece moves, it gains no strength and leaves behind a piece with zero strength. It easily follows from this that moving zero strength pieces is a terrible idea, since:</p>
                <ul>
                    <li>A zero strength piece that moves will necessarily stay at zero strength, because pieces don't gain strength for any turn that they move.</li>
                    <li>A zero strength piece won't ever conqueror any territory, because it has no strength with which to damage other pieces.</li>
                </ul>
                <p>Let's wrap the movement logic inside a function of it's own. This function will take the location of a piece and will return the piece's movement.</p>
                <p>Now we can improve our bot by making sure that we tell all of our zero strength pieces to remain still.</p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-file="Revision1.py"></span>

                <p>Our bot still moves its pieces around a lot (only a bit over one out of five turns will a piece stay still). This costs us a lot of strength (since a piece doesn't gain any strength on turns that it moves). To increase our utilization of our production, let's have pieces only move once their strength equals their production times some factor X. We're using 5 as the value of X in this example, but this is arbitrary.</p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-file="Revision2.py"></span>

                <h3>Moving to Our Borders</h3>
                <p>When building a Halite bot, one of our goals should be moving strength out of your territory quickly and with little production loss. Our current bot is terrible at this. Its pieces move randomly around our territory, going nowhere, costing us production, and often losing strength to the strength cap. </p>
                <p>To improve this, let's just mandate that our pieces move only north and west. Since the map is wrap-around, we can still capture all of the board with this strategy! </p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-file="Revision3.py"></span>

                <h3>Improving our Attack</h3>
                <p>Once our pieces get to our borders, we don't want them to randomly attack just any square (or worse, move back into our territory), as we do now. One problem with this random strategy is that we may attack a map square that has more strength than us. This is unproductive (pun implied) since moving onto the map square costs us a turn of production and we don't actually gain anything. We just diminish the squares strength.</p>
                <p>To improve on our current combat, if there is an enemy or map square that is adjacent to one of our pieces with less strength than our piece, let's take it.</p>
                <span data-gist-id="5ea767bae8a725f738d75649e5f2c91a" data-gist-file="Revision4.py"></span>


            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gist-embed/2.4/gist-embed.min.js"></script>
    <script src="script/backend.js"></script>
    <script src="script/general.js"></script>
</body>
</html>
