<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finish Signup</title>
</head>
<body>

<h2>Almost done 🎉</h2>
<p>No extra info needed.</p>

<form method="POST" action="{{ route('signup.customer.store') }}">
    @csrf
    <button type="submit">Finish</button>
</form>

</body>
</html>
