import NavBar from '../../../../scripts/components/NavBar';
import IconMenuItem from '../../../../scripts/components/IconMenuItem';
import IconButton from '../../../../scripts/components/IconButton';

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

registerBlockType( 'acfg/navbar', {
  title: 'ACFG / NavBar',
  icon: 'universal-access-alt',
  category: 'design',
  example: {},
  edit( {} ) {
    return <div class="nav-bar-block">
        <NavBar>
          <IconMenuItem />
          <IconMenuItem />
          <IconMenuItem />
          <IconButton />
        </NavBar>
      </div>
  },
  save() {
    return <div class="nav-bar-block">
        <NavBar>
          <IconMenuItem />
          <IconMenuItem />
          <IconMenuItem />
          <IconButton />
        </NavBar>
      </div>;
  },
});
