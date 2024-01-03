import EditorJS from '@editorjs/editorjs';
import { Abbreviation } from './abb.js';

const editor = new EditorJS({
  holder: 'editor',
  tools: {
    abbreviation: Abbreviation,
  },
});
