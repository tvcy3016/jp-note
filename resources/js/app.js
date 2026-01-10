import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
  const typeSelect = document.querySelector('[name="note_type"]');
  if (!typeSelect) return;

  const blocks = document.querySelectorAll('[data-note-fields]');

  const toggleFields = () => {
    const type = typeSelect.value;

    blocks.forEach(block => {
      block.style.display =
        block.dataset.noteFields === type ? 'block' : 'none';
    });
  };

  typeSelect.addEventListener('change', toggleFields);

  // 編輯頁 / 新增頁初始狀態
  toggleFields();
});
