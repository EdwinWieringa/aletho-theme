import { registerBlockType } from '@wordpress/blocks';
import { RichText } from '@wordpress/block-editor';

registerBlockType('aletho/check-mark-list', {
  edit({ attributes, setAttributes }) {
    return (
      <ul className="check-mark-list">
        {attributes.items?.map((item, index) => (
          <li key={index}>
            <RichText
              value={item}
              onChange={(value) => {
                const newItems = [...attributes.items];
                newItems[index] = value;
                setAttributes({ items: newItems });
              }}
            />
          </li>
        ))}
      </ul>
    );
  },
  save({ attributes }) {
    return (
      <ul className="check-mark-list">
        {attributes.items?.map((item, index) => (
          <li key={index}>
            <RichText.Content value={item} />
          </li>
        ))}
      </ul>
    );
  },
});
