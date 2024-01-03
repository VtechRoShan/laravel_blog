(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined'
    ? factory(exports)
    : typeof define === 'function' && define.amd
    ? define(['exports'], factory)
    : ((global =
        typeof globalThis !== 'undefined' ? globalThis : global || self),
      factory((global.eonasdan = {})));
})(this, function (exports) {
  /**
   * Build styles
   */
  //require('./index.css').toString();

  /**
   * @typedef {object} AbbreviationData
   * @description Tool's input and output data format
   * @property {string} text — Abbreviation's content
   * @property {string} title - Abbreviation's title
   */

  /**
   * @typedef {object} AbbreviationConfig
   * @description Tool's config from Editor
   * @property {string} placeholder — Block's placeholder
   * @property {number} defaultLevel — default level
   */

  /**
   * Header block for the Editor.js.
   *
   * @author CodeX (team@ifmo.su)
   * @copyright CodeX 2018
   * @license MIT
   * @version 2.0.0
   */
  class Abbreviation {
    /**
     * Render plugin`s main Element and fill it with saved data
     *
     * @param {{data: AbbreviationData, config: AbbreviationConfig, api: object}}
     *   data — previously saved data
     *   config - user config for Tool
     *   api - Editor.js API
     *   readOnly - read only mode flag
     */

    tag = 'abbr';

    constructor({ data, config, api, readOnly }) {
      this.api = api;
      this.readOnly = readOnly;

      /**
       * Styles
       *
       * @type {object}
       */
      // this._CSS = {
      //     block: this.api.styles.block,
      //     settingsButton: this.api.styles.settingsButton,
      //     settingsButtonActive: this.api.styles.settingsButtonActive,
      //     wrapper: 'ce-abbreviation',
      // };

      /**
       * Tool's settings passed from Editor
       *
       * @type {AbbreviationConfig}
       * @private
       */
      this._settings = config;

      /**
       * Block's data
       *
       * @type {AbbreviationData}
       * @private
       */
      this._data = this.normalizeData(data);

      /**
       * List of settings buttons
       *
       * @type {HTMLElement[]}
       */
      this.settingsButtons = [];

      /**
       * Main Block wrapper
       *
       * @type {HTMLElement}
       * @private
       */
      this._element = this.getTag();
    }

    /**
     * Specifies Tool as Inline Toolbar Tool
     *
     * @return {boolean}
     */
    static get isInline() {
      return true;
    }

    /**
     * Normalize input data
     *
     * @param {AbbreviationData} data - saved data to process
     *
     * @returns {AbbreviationData}
     * @private
     */
    normalizeData(data) {
      const newData = {};

      if (typeof data !== 'object') {
        data = {};
      }

      newData.text = data.text || '';
      newData.title = data.title || '';

      return newData;
    }

    // noinspection JSUnusedGlobalSymbols
    surround(range) {
      if (!range) {
        return;
      }

      let termWrapper = this.api.selection.findParentTag(this.tag);

      /**
       * If start or end of selection is in the highlighted block
       */
      if (termWrapper) {
        this.unwrap(termWrapper);
      } else {
        this.wrap(range);
      }
    }

    /**
     * Wrap selection with term-tag
     *
     * @param {Range} range - selected fragment
     */
    wrap(range) {
      /**
       * Create a wrapper for highlighting
       */
      let abbr = document.createElement(this.tag);

      /**
       * SurroundContent throws an error if the Range splits a non-Text node with only one of its boundary points
       * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Range/surroundContents}
       *
       * // range.surroundContents(abbr);
       */
      abbr.appendChild(range.extractContents());
      range.insertNode(abbr);

      /**
       * Expand (add) selection to highlighted block
       */
      this.api.selection.expandToTag(abbr);
    }

    /**
     * Unwrap term-tag
     *
     * @param {HTMLElement} termWrapper - term wrapper tag
     */
    unwrap(termWrapper) {
      /**
       * Expand selection to all term-tag
       */
      this.api.selection.expandToTag(termWrapper);

      let sel = window.getSelection();
      let range = sel.getRangeAt(0);

      let unwrappedContent = range.extractContents();

      /**
       * Remove empty term-tag
       */
      termWrapper.parentNode.removeChild(termWrapper);

      /**
       * Insert extracted content
       */
      range.insertNode(unwrappedContent);

      /**
       * Restore selection
       */
      sel.removeAllRanges();
      sel.addRange(range);
    }

    /**
     * Return Tool's view
     *
     * @returns {HTMLHeadingElement}
     * @public
     */
    render() {
      return this._element;
    }

    /**
     * Create Block's settings block
     *
     * @returns {HTMLElement}
     */
    renderSettings() {
      const holder = document.createElement('div');

      const selectTypeButton = document.createElement('span');

      //selectTypeButton.classList.add(this._CSS.settingsButton);

      // /**
      //  * Highlight current level button
      //  */
      // if (this.currentLevel.number === level.number) {
      //     selectTypeButton.classList.add(this._CSS.settingsButtonActive);
      // }

      /**
       * Add SVG icon
       */
      selectTypeButton.innerHTML = 'hi'; //level.svg;

      /**
       * Save level to its button
       */
      selectTypeButton.dataset.title = 'title';

      /**
       * Set up click handler
       */
      selectTypeButton.addEventListener('click', () => {
        console.log('button clicked');
        //this.setLevel(level.number);
      });

      /**
       * Append settings button to holder
       */
      holder.appendChild(selectTypeButton);

      /**
       * Save settings buttons
       */
      this.settingsButtons.push(selectTypeButton);

      return holder;
    }

    /**
     * Callback for Block's settings buttons
     *
     * @param {number} level - level to set
     */
    setLevel(level) {
      this.data = {
        level: level,
        text: this.data.text,
      };

      /**
       * Highlight button by selected level
       */
      this.settingsButtons.forEach((button) => {
        button.classList.toggle(
          this._CSS.settingsButtonActive,
          parseInt(button.dataset.level) === level
        );
      });
    }

    /**
     * Extract Tool's data from the view
     *
     * @param {HTMLHeadingElement} toolsContent - Text tools rendered view
     * @returns {AbbreviationData} - saved data
     * @public
     */
    save(toolsContent) {
      return {
        text: toolsContent.innerHTML,
        level: this.data.title,
      };
    }

    /**
     * Sanitizer Rules
     */
    static get sanitize() {
      return {
        level: false,
        text: {},
      };
    }

    /**
     * Returns true to notify core that read-only is supported
     *
     * @returns {boolean}
     */
    static get isReadOnlySupported() {
      return true;
    }

    /**
     * Get current Tools`s data
     *
     * @returns {AbbreviationData} Current data
     * @private
     */
    get data() {
      this._data.text = this._element.innerHTML;
      this._data.title = 'todo';

      return this._data;
    }

    /**
     * Store data in plugin:
     * - at the this._data property
     * - at the HTML
     *
     * @param {AbbreviationData} data — data to set
     * @private
     */
    set data(data) {
      this._data = this.normalizeData(data);

      /**
       * If level is set and block in DOM
       * then replace it to a new block
       */
      if (data.text !== undefined && this._element.parentNode) {
        /**
         * Create a new tag
         *
         * @type {HTMLHeadingElement}
         */
        const newAbbreviation = this.getTag();

        /**
         * Save Block's content
         */
        newAbbreviation.innerHTML = this._element.innerHTML;

        /**
         * Replace blocks
         */
        this._element.parentNode.replaceChild(newAbbreviation, this._element);

        /**
         * Save new block to private variable
         *
         * @type {HTMLHeadingElement}
         * @private
         */
        this._element = newAbbreviation;
      }

      /**
       * If data.text was passed then update block's content
       */
      if (data.text !== undefined) {
        this._element.innerHTML = this._data.text || '';
      }
    }

    /**
     * Get tag for target level
     * By default returns second-leveled abbreviation
     *
     * @returns {HTMLElement}
     */
    getTag() {
      /**
       * Create element for current Block's level
       */
      const tag = document.createElement(this.tag);

      /**
       * Add text to block
       */
      tag.innerHTML = this._data.text || '';

      /**
       * Make tag editable
       */
      tag.contentEditable = this.readOnly ? 'false' : 'true';

      /**
       * Add Placeholder
       */
      tag.dataset.placeholder = this.api.i18n.t(
        this._settings.placeholder || ''
      );

      return tag;
    }

    // /**
    //  * Handle H1-H6 tags on paste to substitute it with abbreviation Tool
    //  *
    //  * @param {PasteEvent} event - event with pasted content
    //  */
    // onPaste(event) {
    //     const content = event.detail.data;
    //
    //     /**
    //      * Define default level value
    //      *
    //      * @type {number}
    //      */
    //     let level = this.defaultLevel.number;
    //
    //     switch (content.tagName) {
    //         case 'H1':
    //             level = 1;
    //             break;
    //         case 'H2':
    //             level = 2;
    //             break;
    //         case 'H3':
    //             level = 3;
    //             break;
    //         case 'H4':
    //             level = 4;
    //             break;
    //         case 'H5':
    //             level = 5;
    //             break;
    //         case 'H6':
    //             level = 6;
    //             break;
    //     }
    //
    //     if (this._settings.levels) {
    //         // Fallback to nearest level when specified not available
    //         level = this._settings.levels.reduce((prevLevel, currLevel) => {
    //             return Math.abs(currLevel - level) < Math.abs(prevLevel - level) ? currLevel : prevLevel;
    //         });
    //     }
    //
    //     this.data = {
    //         level,
    //         text: content.innerHTML,
    //     };
    // }
    //
    // /**
    //  * Used by Editor.js paste handling API.
    //  * Provides configuration to handle H1-H6 tags.
    //  *
    //  * @returns {{handler: (function(HTMLElement): {text: string}), tags: string[]}}
    //  */
    // static get pasteConfig() {
    //     return {
    //         tags: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6'],
    //     };
    // }

    /**
     * Get Tool toolbox settings
     * icon - Tool icon's SVG
     * title - title to show in toolbox
     *
     * @returns {{icon: string, title: string}}
     */
    static get toolbox() {
      return {
        icon: '<svg width="17" height="12" viewBox="1 -1 16 15" xmlns="http://www.w3.org/2000/svg"><path d="M17.839 5.525a1.105 1.105 0 0 1-.015 1.547l-4.943 4.943a1.105 1.105 0 1 1-1.562-1.562l4.137-4.137-4.078-4.078A1.125 1.125 0 1 1 12.97.648l4.796 4.796c.026.026.05.053.074.08zm-14.952.791l4.137 4.137a1.105 1.105 0 1 1-1.562 1.562L.519 7.072a1.105 1.105 0 0 1-.015-1.547c.023-.028.048-.055.074-.081L5.374.647a1.125 1.125 0 0 1 1.591 1.591L2.887 6.316z" id="a"/></svg>',
        title: 'Heading',
      };
    }
  }
  exports.Abbreviation = Abbreviation;

  Object.defineProperty(exports, '__esModule', { value: true });
});
