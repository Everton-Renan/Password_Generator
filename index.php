<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Password Generator</title>

    <?php
    const FILE_NAME = 'data.json';

    $symbols = $_GET["symbols"] ?? false;
    $numbers = $_GET["numbers"] ?? false;
    $uppercase = $_GET["uppercase"] ?? false;
    $lowercase = $_GET["lowercase"] ?? false;
    $length = $_GET["length"] ?? false;
    $output = "";

    if ($symbols || $numbers || $uppercase || $lowercase || $length) {
        $checked_options = checkbox($symbols, $numbers, $uppercase, $lowercase);

        generate_json($checked_options, $length);
        $command = escapeshellcmd('python generate_password.py');
        $output = shell_exec($command) ?? "";
    }

    function checkbox($symbols, $numbers, $uppercase, $lowercase)
    {
        // $options[0] = $symbols
        // $options[1] = $numbers
        // $options[2] = $uppercase
        // $options[3] = $lowercase
        $options = [0, 0, 0, 0];

        if ($symbols == true) {
            $options[0] = 1;
        }

        if ($numbers == true) {
            $options[1] = 1;
        }

        if ($uppercase == true) {
            $options[2] = 1;
        }

        if ($lowercase == true) {
            $options[3] = 1;
        }

        return $options;
    }

    function generate_json($options, $length)
    {
        $data = [
            "symbols" => $options[0],
            "numbers" => $options[1],
            "uppercase" => $options[2],
            "lowercase" => $options[3],
            "length" => $length
        ];

        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(FILE_NAME, $json_data);
    }
    ?>
</head>

<body>
    <h1>Password Generator</h1>
    <div id="main-menu">
        <form action="" method="get">
            <div id="forms">
                <input type="checkbox" name="symbols" id="symbols">
                <label for="symbols">Symbols (! @ # $ % & * . ,)</label>
                <br>

                <input type="checkbox" name="numbers" id="numbers">
                <label for="numbers">Numbers (0 1 2 3 4 5 6 7 8 9)</label>
                <br>

                <input type="checkbox" name="uppercase" id="uppercase">
                <label for="uppercase">Uppercase</label>
                <br>

                <input type="checkbox" name="lowercase" id="lowercase">
                <label for="lowercase">Lowercase</label>
                <br>

                <label for="length">Password length:</label>
                <input type="number" name="length" id="length" min="1">
                <br>
            </div>

            <button type="submit">Generate Password</button>
            <br>

            <?php if ($output) : ?>
                <div id="result">
                    <label id="password-generated" for="password">Password generated: </label>
                    <input type="text" name="password" id="password" value="<?= $output ?>">
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>