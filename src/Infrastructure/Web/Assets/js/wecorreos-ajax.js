jQuery(document).ready(
  ($) => {
    $(document).on('change', '.js-ajax-select-coord', function (event) {
      const selectedElement = $(this).find(':selected');
      updateGoogleMapWithCoord(
        selectedElement.attr('data-latitude'),
        selectedElement.attr('data-longitude'),
      );
    });

    $(document).on(
      'click', '.js-ajax-post-request', function (event) {
        event.preventDefault();
        ajaxActionFormRequest($(this));
      },
    );

    $(document).on(
      'change', '.js-ajax-post-request-on-select', function (event) {
        event.preventDefault();
        ajaxActionFormRequest($(this));
      },
    );

    $(document).on(
      'click', '.js-ajax-add-row', function (event) {
        event.preventDefault();
        ajaxAddRowRequest($(this));
      },
    );

    $(document).on(
      'click', '.js-ajax-delete-last-element', function (event) {
        event.preventDefault();
        ajaxDeleteLastElement($(this));
      },
    );

    $(document).on(
      'click', '#doaction, #doaction2', function (event) {
        const action = actionSelected($(this));
        if (isBulkActionFormRequest(action)) {
          event.preventDefault();
          ajaxActionFormRequestBulk(action);
        }
      },
    );

    $(document).on(
      'click', '.js-ajax-post-request-on-modal', function (event) {
        event.preventDefault();
        ajaxActionFormRequestBulk($(this));
        tb_remove();
      },
    );

    $(document).on(
      'click', '#doaction, #doaction2', function (event) {
        const action = actionSelected($(this));
        if (isBulkActionDisplayModalWindow(action)) {
          event.preventDefault();
          displayModalForm(
            action.attr('tbwindow'),
            action.attr('tbwidth'),
            action.attr('tbheight'),
            action.attr('tbtitle'),
          );
        }
      },
    );

    $(document).on(
      'click', '.js-ajax-generate-correos-shipping', function (event) {
        event.preventDefault();
        ajaxActionGenerateShippingFormRequest($(this));
      },
    );

    $(document).on('change', '#metabox-label-form-sender-key', function () {
      const selectedElement = $(this).find(':selected');
      const data = {
        action: 'wecorreos_change_sender',
        order_id: $('[name="metabox-label-form[order_id]"]').val(),
        sender_key: selectedElement.val(),
        nonce: ajax_object.nonce,
      };
      console.log(data);
      ajaxPostRequest(data, undefined, 'we-message-metabox', undefined);
    });

    function updateGoogleMapWithCoord(latitude, longitude) {
      if (latitude === '' || longitude === '') {
        return;
      }
      if (typeof google !== 'object' || typeof google.maps !== 'object') {
        return;
      }

      const latlng = new google.maps.LatLng(latitude, longitude);
      const element = document.getElementById('wecorreos-googlemap');
      element.style.height = '300px';
      const map = new google.maps.Map(element, {
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      });
      console.log('marker');
      const marker = new google.maps.Marker({
        map,
        icon: new google.maps.MarkerImage(iconMarker(), new google.maps.Size(90, 40), new google.maps.Point(0, 0), new google.maps.Point(45, 40)),
      });
      marker.setPosition(latlng);
      map.setCenter(latlng);
    }

    function iconMarker() {
      const element = document.getElementById('wecorreos-select-citypaq-form');
      const icon = element === null ? 'mapmarker_office.png' : 'mapmarker_citypaq.png';
      return ajax_object.plugin_images + icon;
    }

    function ajaxActionGenerateShippingFormRequest(element) {
      const form = element.attr('form');
      const action = actionGenerateShipping(element, form);
      const data = obtainFormData(form, action);
      const message_id = element.attr('message_id');
      const block_element = element.attr('block_element');
      ajaxPostRequest(data, form, message_id, block_element);
    }

    function actionGenerateShipping(element, form) {
      const offices_correos_types = ['paq48office', 'paq72office'];
      const citypaq_correos_types = ['paq48citypaq', 'paq72citypaq'];
      const object = starterpluginforms.objectFromPrefixedElements(form, ajax_object.nonce);

      if (offices_correos_types.includes(object.correos_type)) {
        return element.attr('second_action');
      }

      if (citypaq_correos_types.includes(object.correos_type)) {
        return element.attr('third_action');
      }
      return element.attr('action');
    }

    function actionSelected(element) {
      return $(element.closest('.bulkactions').find(':selected'));
    }

    function isBulkActionFormRequest(element) {
      const actionClass = element.attr('class');
      return actionClass == 'js-ajax-post-request-bulk';
    }

    function isBulkActionDisplayModalWindow(element) {
      const actionClass = element.attr('class');
      return actionClass == 'js-display-modal-window-bulk';
    }

    function ajaxActionFormRequestBulk(element) {
      const message_id = element.attr('message_id');
      const message_updating = element.attr('message_updating');
      starterpluginmessages.deleteAll(message_id);
      starterpluginmessages.displaySuccess(message_id, message_updating);

      const form = element.attr('form');
      const data = starterpluginforms.objectFromPrefixedElements(form, ajax_object.nonce);

      data.action = element.attr('action');
      data.order_ids = obtainSelectedOrderIds();
      const block_element = element.attr('block_element');
      ajaxPostRequest(data, form, message_id, block_element);
    }

    function obtainSelectedOrderIds() {
      const ids = [];

      $('#the-list th.check-column input[type="checkbox"]:checked').each(
        function () {
          ids.push($(this).val());
        },
      );

      return ids.length > 0 ? JSON.stringify(ids) : '';
    }

    function displayModalForm(window, width, height, title) {
      tb_show(
        title, // Title.
        `#TB_inline?width=${width}&height=${height}&inlineId=${window}`, // url.
        false, // Images.
      );
    }

    function ajaxAddRowRequest(element) {
      const form = element.attr('form');
      const data = {};

      data.nonce = ajax_object.nonce;
      data.action = element.attr('action');
      data.key = obtainNewKey(form);
      data.add_id = element.attr('add_id');
      data.form = form;

      const message_id = element.attr('message_id');
      ajaxPostRequest(data, undefined, message_id, data.add_id);
    }

    function ajaxDeleteLastElement(control) {
      const parentElement = $(`#${control.attr('parent')}`);
      const almostOneInParent = control.attr('almostone');
      const block_element = control.attr('block_element');
      const id = control.attr('message_id');

      block(block_element);

      if (almostOneInParent && parentElement.children().length == 1) {
        starterpluginmessages.displayWarning(id, ajax_object.deletelastelement);
      } else {
        parentElement.children().last().remove();
      }

      unBlock(block_element);
    }

    function ajaxActionFormRequest(element) {
      const form = element.attr('form');
      const data = obtainFormData(form, element.attr('action'));
      const message_id = element.attr('message_id');
      const block_element = element.attr('block_element');
      ajaxPostRequest(data, form, message_id, block_element);
    }

    function ajaxPostRequest(data, form, message_id, block_element) {
      block(block_element);

      $.ajax(
        {
          type: 'POST',
          url: ajax_object.ajax_url,
          data,
          success(response) {
            manage_reponse(response, form, message_id);
            unBlock(block_element);
          },
          error(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            unBlock(block_element);
          },
        },
      );
    }

    function obtainFormData(form, action) {
      const object = starterpluginforms.objectFromPrefixedElements(form, ajax_object.nonce);

      object.action = action;

      return object;
    }

    function manage_reponse(response, form, message_id) {
      let display_message = false;

      let first_display_message_id = null;

      starterpluginmessages.deleteAll(message_id);

      if (typeof response.replace !== 'undefined') {
        if (Array.isArray(response.replace)) {
          response.replace.forEach(
            (replace) => {
              starterpluginelements.replaceContentInElement(replace.id, replace.content);
            },
          );
        } else {
          starterpluginelements.replaceContentInElement(
            response.replace.id,
            response.replace.content,
          );
        }
      }
      if (typeof response.success !== 'undefined') {
        var id = message_id;
        var message = response.success;
        if (typeof response.success === 'object') {
          id = response.success.id;
          message = response.success.success;
        }
        starterpluginmessages.displaySuccess(id, message);
        display_message = true;
        first_display_message_id = first_display_message_id === null ? id : first_display_message_id;
      }
      if (typeof response.warning !== 'undefined') {
        var id = message_id;
        var message = response.warning;

        if (typeof response.warning === 'object') {
          id = response.warning[id];
          message = response.warning[warning];
        }

        starterpluginmessages.displayWarning(id, message);
        display_message = true;
        first_display_message_id = first_display_message_id === null ? id : first_display_message_id;
      }
      if (typeof response.error !== 'undefined') {
        var id = message_id;
        var message = response.error;

        if (typeof response.error === 'object') {
          id = response.error[id];
          message = response.error[error];
        }

        starterpluginmessages.displayError(id, message);
        display_message = true;
        first_display_message_id = first_display_message_id === null ? id : first_display_message_id;
      }
      if (typeof response.sanitized !== 'undefined') {
        starterpluginforms.populatePrefixedElementsFromObject(
          form,
          response.sanitized,
        );
      }
      if (typeof response.add !== 'undefined') {
        $(`#${response.add.id}`).append(response.add.content);
      }

      if (typeof response.reload !== 'undefined') {
        location.reload();
      }

      if (typeof response.changed_order_status !== 'undefined') {
        if (response.changed_order_status !== 'no_change') {
          update_status_order(response.changed_order_status);
        }
      }

      if (display_message) {
        scrollToMessage(first_display_message_id);
      }
    }

    function update_status_order(status_order) {
      $('#order_status').val(status_order);
      $('#order_status').select2().trigger('change');
    }

    function scrollToMessage(element) {
      $([document.documentElement, document.body]).animate(
        {
          scrollTop: $(`#${element}`).offset().top - 50,
        }, 500,
      );
    }

    function block(element) {
      if (element !== 'undefined') {
        $(`#${element}`).block(
          {
            message: null,
            overlayCSS: {
              background: '#fff',
              opacity: 0.6,
            },
          },
        );
      }
    }

    function unBlock(element) {
      if (element !== 'undefined') {
        $(`#${element}`).unblock();
      }
    }

    function extractIndex(uglyName) {
      const elements = /\[(\d+)\]/.exec(uglyName);
      return elements.pop();
    }

    function obtainNewKey(form) {
      const allKeys = [];

      const elements = starterpluginforms.searchPrefixedElements(form);

      if (elements.length == 0) {
        return 1;
      }

      elements.forEach(
        (element) => {
          const index = extractIndex(element.name);
          allKeys.push(Number(index));
        },
      );

      const uniqueKeys = allKeys.filter(
        (a, b) => allKeys.indexOf(a) == b,
      );

      const lastNumber = uniqueKeys.sort(
        (a, b) => a - b,
      ).pop();

      return lastNumber + 1;
    }
  },
);

var starterpluginforms = {
  objectFromPrefixedElements(prefix, nonce) {
    const object = {};

    if (prefix !== 'null') {
      this.searchPrefixedElements(prefix).forEach(
        (element) => {
          if (this.isSubFieldElement(element.name)) {
            const nameIndex = this.extractFieldSubFieldAndIndex(element.name);

            const nameField = nameIndex[1];

            const nameSubField = nameIndex[2];

            const indexField = nameIndex[3];

            if (!object.hasOwnProperty(nameField)) {
              object[nameField] = {};
            }
            if (!object[nameField].hasOwnProperty(nameSubField)) {
              object[nameField][nameSubField] = {};
            }
            if (this.avoidRadioElementNotChecked(element)) {
              object[nameField][nameSubField][indexField] = this.extractElementValue(element);
            }
          } else if (this.avoidRadioElementNotChecked(element)) {
            object[this.extractBetweenBrackets(element.name)] = this.extractElementValue(element);
          }
        },
      );
    }

    object.nonce = nonce;

    return this.subFieldsToJSON(object);
  },

  avoidRadioElementNotChecked(element) {
    if (element.type != 'radio') {
      return true;
    }

    if (element.checked) {
      return true;
    }

    return false;
  },


  subFieldsToJSON(object) {
    const objectSONValues = {};

    for (const property in object) {
      let value = object[property];

      if (typeof value === 'object' && !Array.isArray(value)) {
        value = JSON.stringify(value);
      }
      objectSONValues[property] = value;
    }

    return objectSONValues;
  },

  formDataFromPrefixedElements(prefix, nonce, extra = {}) {
    const formData = new FormData();
    const object = this.objectFromPrefixedElements(prefix);

    for (var property in object) {
      formData.append(property, object[property]);
    }

    for (var property in extra) {
      let value = extra[property];
      value = Array.isArray(value) ? JSON.stringify(value) : value;
      formData.append(property, value);
    }

    formData.append('nonce', nonce);

    return formData;
  },

  populatePrefixedElementsFromObject(prefix, object) {
    this.searchPrefixedElements(prefix).forEach(
      (element) => {
        const value = this.extractObjectValue(object, element.name);

        if (typeof value !== 'undefined') {
          this.populateValue(element, value);
        }
      },
    );
  },

  populateValue(element, value) {
    if (element.multiple) {
      this.selectOptions(element, value);
      return;
    }

    if (element.type === 'checkbox') {
      element.checked = value;
      return;
    }

    element.value = value;
  },

  selectOptions(element, value) {
    Array.prototype.forEach.call(
      element.options, (option) => {
        option.selected = !!value.includes(option.value);
      },
    );
  },

  extractElementValue(element) {
    if (element.multiple) {
      return this.extractMulipleValues(element);
    }

    if (element.type === 'checkbox') {
      return element.checked;
    }

    return element.value;
  },

  extractMulipleValues(element) {
    const checkedValues = [];

    Array.prototype.forEach.call(
      element.selectedOptions, (option) => {
        checkedValues.push(option.value);
      },
    );

    return checkedValues;
  },

  extractObjectValue(object, uglyName) {
    if (this.isSubFieldElement(uglyName)) {
      const nameIndex = this.extractFieldSubFieldAndIndex(uglyName);

      const nameField = nameIndex[1];

      const indexField = nameIndex[2];

      const nameSubField = nameIndex[3];

      if (object[nameField] === undefined) {
        return undefined;
      }

      objectField = object[nameField].filter(
        (element) => element.key == indexField,
      );

      return objectField[0][nameSubField];
    }

    return object[this.extractBetweenBrackets(uglyName)];
  },

  isSubFieldElement(name) {
    return /\[(.*?)\]\[(.*?)\]\[(.*?)\]/.test(name);
  },

  extractFieldSubFieldAndIndex(uglyName) {
    return /\[(.*?)\]\[(.*?)\]\[(.*?)\]/.exec(uglyName);
  },

  extractBetweenBrackets(uglyName) {
    return /\[(.*?)\]/.exec(uglyName)[1];
  },

  searchPrefixedElements(prefix) {
    return document.getElementById(prefix).querySelectorAll(`[name^=${prefix}\\[]`);
  },
};

var starterpluginmessages = {

  displaySuccess(id, message, tag = 'div') {
    this.displayMessage(id, message, 'updated', tag);
  },

  displayWarning(id, message, tag = 'div') {
    this.displayMessage(id, message, 'notice-warning', tag);
  },

  displayError(id, message, tag = 'div') {
    this.displayMessage(id, message, 'error', tag);
  },

  deleteAll(id, withClass = null) {
    starterpluginelements.deleteContentInElement(id);
    starterpluginelements.deleteContentInElementWithClass(withClass);
  },

  displayMessage(id, message, level, tag) {
    const buildedMessage = `<${tag} class="${level} notice published"><p>${message}</p></${tag}>`;

    starterpluginelements.addContentToElement(id, buildedMessage);
  },
};

var starterpluginelements = {

  replaceContentInElement(id, content) {
      console.log('id',id);
    document.getElementById(id).innerHTML = content;
  },

  addContentToElement(id, content) {
    const element = document.getElementById(id);

    element.innerHTML += content;
  },

  deleteContentInElement(id) {
    this.replaceContentInElement(id, '');
  },

  deleteContentInElementWithClass(withClass) {
    document.querySelectorAll(`.${withClass}`).forEach(
      (element) => {
        element.innerHTML = '';
      },
    );
  },
};
