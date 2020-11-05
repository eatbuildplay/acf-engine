import RenderDate from '../../../../scripts/components/RenderDate';

const {
  RichText,
  AlignmentToolbar,
  BlockControls,
  BlockAlignmentToolbar,
  InspectorControls,
} = wp.blockEditor;
const {
  Toolbar,
  Button,
  ButtonGroup,
  Tooltip,
  PanelBody,
  PanelRow,
  FormToggle,
} = wp.components;

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

const MyButtonGroup = () => (
  <ButtonGroup>
    <Button isPrimary>Button 1</Button>
    <Button isPrimary>Button 2</Button>
  </ButtonGroup>
);

const blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
};

registerBlockType( 'acfg/fancytext', {
  title: 'ACFG / Fancy Text',
  icon: 'universal-access-alt',
  category: 'design',
  example: {},
  edit( {} ) {

    return <div><Button>Click Me!</Button>
      <InnerBlocks />
      <InspectorControls>
        <MyButtonGroup />
      </InspectorControls></div>

  },
  save() {
    return <div>Fancy Text Saved Content <RenderDate date="2021-01-01" /></div>;
  },
});
