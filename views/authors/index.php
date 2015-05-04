<h1>List of Authors</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th colspan="2">Action</th>
    </tr>
    <?php foreach ($this->authors as $author) : ?>
        <tr>
            <td><?= htmlspecialchars($author['id']) ?></td>
            <td><?= htmlspecialchars($author['name']) ?></td>
            <td><a href="/authors/edit/<?=$author['id'] ?>">[Edit]</td>
            <td><a href="/authors/delete/<?=$author['id'] ?>">[Delete]</td>
        </tr>
    <?php endforeach ?>
</table>

<a href="/authors/create">[Create New]</a>
