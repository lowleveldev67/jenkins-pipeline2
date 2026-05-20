<?php
require 'db.php';
$result = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="page-header">
  <span class="page-title">Book List</span>
  <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Book</button>
</div>

<div class="table-wrap">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Author</th>
          <th>Genre</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) === 0): ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-4">No books yet. Add one!</td>
          </tr>
        <?php else: ?>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= htmlspecialchars($row['genre']) ?></td>
            <td>
              <span class="<?= $row['status'] === 'Read' ? 'badge-read' : 'badge-unread' ?>">
                <?= $row['status'] ?>
              </span>
            </td>
            <td>
              <button class="btn btn-outline-secondary btn-sm"
                onclick="openEdit(<?= $row['id'] ?>, '<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['author'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['genre'], ENT_QUOTES) ?>', '<?= $row['status'] ?>')">
                Edit
              </button>

              <form action="action.php" method="POST" class="d-inline"
                onsubmit="return confirm('Delete this book?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="action.php" method="POST">
        <input type="hidden" name="action" value="add">
        <div class="modal-header">
          <h6 class="modal-title">Add Book</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Genre</label>
            <input type="text" name="genre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="Unread">Unread</option>
              <option value="Read">Read</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-add btn-sm">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="action.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="editId">
        <div class="modal-header">
          <h6 class="modal-title">Edit Book</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" id="editTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Author</label>
            <input type="text" name="author" id="editAuthor" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Genre</label>
            <input type="text" name="genre" id="editGenre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="editStatus" class="form-select">
              <option value="Unread">Unread</option>
              <option value="Read">Read</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-add btn-sm">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openEdit(id, title, author, genre, status) {
    document.getElementById('editId').value     = id;
    document.getElementById('editTitle').value  = title;
    document.getElementById('editAuthor').value = author;
    document.getElementById('editGenre').value  = genre;
    document.getElementById('editStatus').value = status;
    new bootstrap.Modal(document.getElementById('editModal')).show();
  }
</script>

</body>
</html>