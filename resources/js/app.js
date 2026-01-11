import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const noteTypeSelect = document.querySelector('[name="note_type"]');
  if (noteTypeSelect) {
    const blocks = document.querySelectorAll('[data-note-fields]');

    const toggleFields = () => {
      const type = noteTypeSelect.value;

      blocks.forEach(block => {
        block.style.display =
          block.dataset.noteFields === type ? 'block' : 'none';
      });
    };

    noteTypeSelect.addEventListener('change', toggleFields);
    toggleFields();
  }

  const questionTypeSelect = document.querySelector('[name="question_type"]');
  if (questionTypeSelect) {
    const blocks = document.querySelectorAll('[data-question-fields]');

    const toggleQuestionFields = () => {
      const type = questionTypeSelect.value;

      blocks.forEach(block => {
        block.style.display =
          block.dataset.questionFields === type ? 'block' : 'none';
      });
    };

    questionTypeSelect.addEventListener('change', toggleQuestionFields);
    toggleQuestionFields();
  }
});
