// import { registerBlockType } from '@wordpress/blocks';

const { registerBlockType } = wp.blocks;

const blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
};

function Test123() {
  return 'love yourself!';
}

registerBlockType( 'acfg/fancytext', {
  title: 'ACFG / Fancy Text',
  icon: 'universal-access-alt',
  category: 'design',
  example: {},
  edit() {
      return <Test123 />;
  },
  save() {
      return <div style={ blockStyle }>Hello World, step 1 (from the frontend).</div>;
  },
});
